<template>
  <div>
    <div class="d-flex" id="wrapper">
      <navbar/>
      <div id="page-content-wrapper">
        <nav class="navbar navbar-light bg-light">
          <button class="btn btn-outline-primary" id="menu-toggle">Menu</button>
          <search/>
        </nav>
        <div class="container-fluid">
        <router-view :key="$route.params.id"/>
        </div>
      </div>
    </div>
  </div>
</template>
