<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Technique;
use App\Models\Tactic;
use Illuminate\Support\Facades\Log;
use Throwable;

class ApiController extends Controller
{
    public object $techniqueModel;
    public object $tacticModel;

    public function __construct()
    {
        $this->tacticModel = new Tactic();
        $this->techniqueModel = new Technique();
    }

    /**
     * Returns all or single tactic data by id parameter
     * Put 0 if you want get all techniques
     * @param integer $id
     * @return array
     */
    public function getTactic(int $id = 0): array
    {
        $emptyTactic = [
            'id' => '',
            'name' => '',
            'description' => ''
        ];

        try {
            if($id > 0) {
                $tactics = $this->tacticModel->where('id', $id)->get(['id', 'name', 'description'])->toArray();
            } else {
                $tactics = $this->tacticModel->get(['id', 'name', 'description'])->toArray();
            }
    
            if(empty($tactics)) {
                $tactics[0] = $emptyTactic;
            }
        } catch(Throwable $e) {
            Log::error('Cant getTactic() from API. Error: ' . $e->getMessage());
            $tactics[0] = $emptyTactic;
        }

        return $tactics;
    }

    /**
     * Returns all techniques or techniques assigned to a specific tactic by tactic_id parameter
     * Put 0 if you want get all techniques
     * @param integer $tacticid
     * @return array
     */
    public function getTechniques(int $tactic_id = 0): array
    {
        $emptyTechnique = [
            'id' => '',
            'name' => '',
            'description' => ''
        ];

        try {
            if($tactic_id == 0) {
                $technique = $this->techniqueModel->get(['id', 'name', 'description'])->toArray();
            } else {
                $technique = $this->techniqueModel->whereHas('relation', function ($query) use($tactic_id){
                    return $query->where('tactic_id', '=', $tactic_id);
                })->get(['id', 'name', 'description'])->toArray();
            }
    
            if(empty($technique)) {
                $technique[0] = $emptyTechnique;
            }
        } catch(Throwable $e) {
            Log::error('Cant getTechniques() from API. Error: ' . $e->getMessage());
            $technique[0] = $emptyTechnique;
        }

        return $technique;
    }

    /**
     * Returns single technique data by technique_id parameter
     *
     * @param integer $id
     * @return array
     */
    public function getTechnique(int $id): array
    {
        $technique = $this->techniqueModel->where('id', $id)->first(['name', 'description']);

        if(empty($technique)) {
            $technique = [
                'name' => '',
                'description' => ''
            ];
        } else {
            $technique = $technique->toArray();
        }

        return $technique;
    }

}
