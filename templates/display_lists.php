<?php
include_once("database/connection.php");
include_once("database/projects.php");
?>


<div id="display_lists">
<!--Se tiver feito login -->
  <section id="List">
    <!--ciclo for para inserir as categorias -->
     <article>
      <header>
        <h1>SuperMarket</h1>
        <!--ciclo for para inserir as listas -->
        <div id="list_item">
          <p>Amanha</p>
          <input id="delete" type="image"  src="assets/delete.png">
        </div>
        <!--/ciclo for para inserir as listas/-->
      </header>
    </article>
  <!--/ciclo for para inserir as categorias/ -->
  </section>
<!--/Se tiver feito login/ -->
</div>
