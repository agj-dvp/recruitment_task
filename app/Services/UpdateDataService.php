<?php

namespace App\Services;
use App\Models\Tactic;
use App\Models\Technique;
use App\Models\Relation;
use Illuminate\Support\Facades\Log;
use Throwable;

class UpdateDataService 
{
    private string $jsonFileUrl = 'https://raw.githubusercontent.com/mitre/cti/master/enterprise-attack/enterprise-attack.json';
    private array $allData;

    public function __construct()
    {
       $this->allData = $this->getAllData();
    }


    /**
     * Returns all data from JSON file on github
     * 
     * @return array
     */
    public function getAllData(): array
    {
        $data = json_decode(file_get_contents($this->jsonFileUrl, true),true);
        return $data['objects'];
    }

    /**
     * Update tables with tactics and techniques basing on JSON file
     * 
     * @return bool
     */
    public function updateTables(): bool
    {
        echo "Start updating... \n";
        $success = false;
            try {
                foreach($this->allData as $item) {
                    // updating tactics 
                    if($item['type'] == 'x-mitre-tactic') {
                        Tactic::updateOrCreate([
                            'tactic_id' => $item['id']
                        ], [
                            'shortname' => $item['x_mitre_shortname'],
                            'name' => $item['name'],
                            'description' => $item['description'],
                        ]);
                    }

                    // updating techniques
                    if($item['type'] == 'attack-pattern' and isset($item['description'])) {
                        $tmpPhase = array();
                        foreach($item['kill_chain_phases'] as $phase) {
                            $tmpPhase[] = $phase['phase_name'];
                        }
        
                        $phase = implode(',', $tmpPhase);
        
                        Technique::updateOrCreate([
                            'attack_pattern_id' => $item['id']
                        ], [
                            'name' => $item['name'],
                            'description' => $item['description'],
                            'parent_shortnames' => $phase,
                        ]);
                    }
                    $success = true;
                }
                Log::info('Tactics and techniques are updated successfully.');
            } catch(Throwable $e) {
                Log::error('Tactics and techniques update failed. Error:' . $e->getMessage());
                return $success;
            }

        // updating relations
        if($this->updateRelations()) {
            $success = true;
        }

        if($success = true) {
            echo "Update success. Data is up to date. Check logs in '/storage/logs/laravel.log' \n";
        } else {
            echo "Update failed. Check logs in '/storage/logs/laravel.log'. \n";
        }
        return $success;
    }

    /**
     * Updates relations between tactics and techniques
     *
     * @return bool
     */
    public function updateRelations(): bool
    {
        $success = false;
        try {
            Relation::truncate();
            foreach(Technique::all()->toArray() as $technique) {
                $parentShortnames = explode(',', $technique['parent_shortnames']);
                foreach($parentShortnames as $parentShortname) {
                        $input[] = [
                            'tactic_id' => $this->getTacticIdByShortname($parentShortname),
                            'technique_id' => $technique['id']
                        ];
                }
            }
            Relation::insert($input);
            $success = true;
            Log::info('Relations are updated successfully.');
        } catch(Throwable $e) {
            Log::error('Relations update failed. Error:' . $e->getMessage());
            $success = false;
        }

        return $success;
    }

    /**
     * Returning id of tactic by giving shortname of tactic
     *
     * @param string $shortname
     * @return integer
     */
    public function getTacticIdByShortname(string $shortname = ''): int
    {
        try {
            $id = Tactic::where('shortname', $shortname)->firstOrFail()->id;
        } catch(Throwable $e) {
            $id = 0;
        }

        return $id;
    }
}