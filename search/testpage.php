<div class="container">
    <div class="row" style="text-align: center">
    <h2> Search Results: </h2>
    </div>
  </div>
  <div class="page"></div>
  
        <?php
        if(isset($results)) {
         $max = sizeof($results);
         $pagesize =10;
         $pagecount = $max/$pagesize;
            foreach($results as $key=>$r) {

             if($key<$pagesize)
             {

             
            ?>
            
              
                <div class="row" style="text-align: center">
           <div class="container initial">
          <div class="panel panel-success">
                      <div class=panel-heading style="background-color : aliceblue;">  
                        <h2 class=panel-title>
                          <a href="<?php echo $r['_source']['movie_imdb_link']; ?>" target="_blank"><p><br>
                            <?php echo $r['_source']['movie_title']; ?>
                          </a>
                      </div>
                        <br><br>
                          <b>Movie Director</b><p > 
                              <?php echo  $r['_source']['director_name']; ?><p></p><br>
                              
                              <b>Actor</b><p> 
                              <?php echo  $r['_source']['actor_1_name']; ?><p></p><br>
                              <b>Genres</b><p> 
                              <?php echo  $r['_source']['genres']; ?><p></p><br>
                              <b>Rating</b><p> 
                              <?php echo  $r['_source']['imdb_score']; ?><p></p><br>

                      <!-- <div class="">
                          <b>Id:</b>
                            <center>
                                <?php echo $r['_id']; ?>
                            </center>
                          <br>
                    </div>  -->
                    <input method= "POST" id="<?php echo $r['_id']; ?>" type="submit" class="btn btn-success save" value="Save" style="
    background-color: skyblue;">
                     <br>
               <br>
                  </div>
                  
                </div>
               
                
            <?php
             }
            } 
            
            ?>
            </div>
            
            <nav aria-label="...">
            <ul class="pagination">
               

             
            <?php
            
            for($i=1;$i<$pagecount;$i++){
            ?>

               <li class="page-item"><a class="page-link searchresult" id="<?php echo $q ?>" href="#" value=<?php echo $i?>><?php echo $i ?></a></li>
            <?php       
            }

          
            ?>

               
            </ul>
            </nav>
               
               
           
          
            <?php
        }
        ?>
