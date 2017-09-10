<?php  
        try
        {
            set_time_limit (600);
            date_default_timezone_set('UTC');
            require_once __DIR__ . '/php-graph-sdk-5.0.0/php-graph-sdk-5.0.0/src/Facebook/autoload.php';
            $fb = new Facebook\Facebook(['app_id' => '265499893903510','app_secret' => 'e644807435a20202e2fc4ec8f717d4e8','default_graph_version' => 'v2.8',]);

            // Sets the default fallback access token so we don't have to pass it to each request
            $fb->setDefaultAccessToken('EAADxeILdMJYBAIgxshGnz9GYVc7aXk03oi3k7wfRzyCjD2PjebEJ9hMpARdU64kSYZCoZBE2abA6uZAUn01TZBl0GZBSpQj3midIrYXeKIxBGYl72OBaTosgqUz9dFwveZAtpUKNEZBF400LZAiP4spmY372RxzZCMx8ZD');
    
            //initialize php elements
           
            //first results
            if(isset($_GET['basic']))
            {
                //echo "basic";
//                $query = "/me/";
//                $res = $fb->get($query);
//                $a = json_decode($res->getBody(),true);
//                $a1 = json_encode($a);
//                //echo $a1;
//                echo $_GET['keyword'];
//                echo $_GET['tab'];
                
                
                //basic fb query
                $keyword = $_GET['keyword'];
                $type = $_GET['tab'];
                
                $query = "/search?q=".$keyword."&type=".$type."&fields=id,name,picture";
                $result = $fb->get($query);
                $resJson = $result->getDecodedBody();
                //echo json_encode($resJson);
                //$resultData = json_encode($resJson['data']);
                //$pagingInfo = json_encode($resJson['paging']);
                
                //if(count($resJson["paging"]) == 1)
                if(!isset($resJson["paging"]["previous"]))
                {
                     $result = array( 'data' => $resJson["data"], 'next' => $resJson["paging"]["next"], 'prev'=>"no-data" );
                }
                else
                {
                     $result = array( 'data' => $resJson["data"], 'next' => $resJson["paging"]["next"], 'prev'=>$resJson["paging"]["previous"] );
                }
                $res = json_encode($result);
                echo $res;
                //$result['data'] = $resultData;
                //$result['paging'] = $pagingInfo;
                //$final  =  json_encode( $resJson,true );
                //echo $final;
                //$ar = [$resultStr,$pagingInfo];
                //$resultStr = $result->getGraphEdge();
                
                
                
                //echo $pagingInfo;
                //echo $resultStr;
                //echo implode(" ",$ar);
            }
            
            //next results
            if(isset($_GET['next']))
            {
                //echo "next";
                $nextUrl = $_GET['nextUrl'];
               // $resJson = file_get_contents($nextUrl);
                
                
                //try
                
                $queryStr = explode("search", $nextUrl);
                $query= "/search".$queryStr[1];

                $result = $fb->get($query);
                $resJson = $result->getDecodedBody();
                //if(count($resJson["paging"]) == 1)
                if(!isset($resJson["paging"]["previous"]))
                {
                     $result = array( 'data' => $resJson["data"], 'next' => $resJson["paging"]["next"], 'prev'=>"no-data" );
                }
                else
                {
                     $result = array( 'data' => $resJson["data"], 'next' => $resJson["paging"]["next"], 'prev'=>$resJson["paging"]["previous"] );
                }
                //$result = array( 'data' => $resJson["data"], 'next' => $resJson["paging"]["next"], 'prev'=>"no-data" );
                $res = json_encode($result);
                echo $res;
                
                //try
                
//                $result = array( 'data' => $resJson["data"], 'next' => $resJson["paging"]["next"], 'prev'=>$resJson["paging"]["pevious"] );
//                $res = json_encode($result);
//                echo $res;
                //$res = $resultStr->getDecodedBody();
                //echo $resultStr['data'];
                //echo $current;
                
            }
            
            //prev results
            if(isset($_GET['prev']))
            {
                //echo "prev";
                $prevUrl = $_GET['prevUrl'];
                $queryStr = explode("search", $prevUrl);
                $query= "/search".$queryStr[1];

                $result = $fb->get($query);
                $resJson = $result->getDecodedBody();
                //if(count($resJson["paging"]) == 1)
                if(!isset($resJson["paging"]["previous"]))
                {
                     $result = array( 'data' => $resJson["data"], 'next' => $resJson["paging"]["next"], 'prev'=>"no-data" );
                }
                else
                {
                     $result = array( 'data' => $resJson["data"], 'next' => $resJson["paging"]["next"], 'prev'=>$resJson["paging"]["previous"] );
                }
               
                $res = json_encode($result);
                echo $res;
            }
            
            
            
            //details page
            if(isset($_GET['details']))
            {
                    $id = $_GET['id'];
                    //echo $id;
                    //albums and posts details
                    //$query = "/".$id."/?fields=id,name,picture.width(700).height(700),albums.limit(5){name,photos.limit(2){name, picture}},posts.limit(5)";
                    $query = "/".$id."/?fields=albums.limit(5)";
                    //$query = "/".$id."/albums";
                    $result = $fb->get($query);
                    $albData = $result->getDecodedBody();
                    //echo json_encode($albData);
                    if(isset($albData['data']))
                    {
                        $alb = $albData['data'];
                    }
                    else
                    {
                        if(isset($albData['albums']['data']))
                        {
                            $alb = $albData['albums']['data'];
                        }
                        else
                        {
                            $alb = [];
                        }
                    }
                    
                    //try
                
                    //echo json_encode($resJsonAlbum);
                    //$resAlb= json_encode($resJsonAlbum);
                   // $albums = json_encode($resJson);
                
        
                    $query1 = "/".$id."/?fields=posts.limit(5)";
                    //$query1 = "/me/posts";
                    $result1 = $fb->get($query1);
                    $postsData = $result1->getDecodedBody();
                    //echo json_encode($postsData);
                    //echo json_encode($resJsonPosts);
                    //$resPos =  json_encode($resJsonPosts);
                    //$posts = json_encode($resJson);
                
                    //try
                    if(isset($postsData['data']))
                    {
                        $posts = $postsData['data'];
                    }
                    else
                    {
                        if(isset($postsData['posts']['data']))
                        {
                            $posts = $postsData['posts']['data'];
                        }
                        else
                        {
                            $posts = [];
                        }
                    }
                    
                    //try
                   // $posts = $postsData['posts']['data'];
//                  $details = array('albums' => $resJsonAlbum['data'] , 'posts' => $resJsonPosts['posts']['data']);
//                  $ar = json_encode($details);
//                  echo $ar;
                    
                
                    $res = array('albums' => $alb ,  'posts' => $posts);
                    $output = json_encode($res);
                    echo $output;
                
            }
            
            
            }
            catch(\Exception $e)
            {
                echo 'Caught exception: yo ',  $e->getMessage(), "\n";
            }
    
    //    function buildQuery($type,$keyword)
    //    {
    //        $query = "query, fb query!";
    //        return $query;
    //    }
    //
    //    function getData($query)
    //    {
    //        return "data, fb data!!";
    //    }

    
?>
                  