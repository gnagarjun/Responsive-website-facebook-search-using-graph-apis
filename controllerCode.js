                        
var app = angular.module('searchApp', []);

//initialize
    app.controller('mainCtrl', function($scope,$http) {
    $scope.tableView = false;
//     window.fbAsyncInit = function(name) {
//    FB.init({
//      appId      : '265499893903510',
//      status: true,
//      cookie: true,
//      xfbml      : true,
//      version    : 'v2.4'
//    });
//    FB.AppEvents.logPageView();
//  };
//
//  (function(d, s, id){
//     var js, fjs = d.getElementsByTagName(s)[0];
//     if (d.getElementById(id)) {return;}
//     js = d.createElement(s); js.id = id;
//     js.src = "//connect.facebook.net/en_US/sdk.js";
//     fjs.parentNode.insertBefore(js, fjs);
//   }(document, 'script', 'facebook-jssdk'));
        
    $scope.postFbFunc=function()
           {
        window.alert("inside fbpost");
    }

    $scope.checkPrev = function()
    {
        if(!(new String($scope.prevUrl).valueOf()).startsWith("http"))
        {
            //window.alert("no prev so disabling");
            $scope.prevButton = false;
        } 
       // window.alert("no prev so disabling after");
    };
    //window.alert($scope.currentEdge);
    //button click event
        
    $scope.buttonClick = function(tab)
    {
        $scope.searchFbFunc($scope.keyword,tab);    
    };
        
    //tabs switching events
    $scope.tabClick = function(tab)
    {
        $scope.searchFbFunc($scope.keyword,tab);
        $scope.tab = tab;
    };
            
    //button click and tab switching event logic
    $scope.searchFbFunc = function(key,type)
    {
        window.alert("before ajax"+key+"asdf"+type);
        $.ajax({
        url: 'phpFunctions.php',
        type: 'GET',
        data: {"basic":"basic","keyword":key, "tab":type},
        complete: function(e,xhr)
        {
            window.alert(e.status);
            //window.alert("complete");
            //$scope.progressBar();
        },
            success: function(results,jqXHR){
        
            //$len = results.length;
            
            window.alert(results);      
            
            var statusval = jqXHR;
            $scope.updateTable(results);
            $scope.$apply();
            
        },
        error: function($xhr) {
        $response = $xhr.responseText;
        //console.log(response);
        $statusMessage = $xhr.status + ' ' + $xhr.statusText;
        $message  = 'Query failed, php script returned this status: ';
        $message = $message + $statusMessage + ' response: ' + $response;
        window.alert($message);  
        }
        });  
    };
  
    
        
        
    
 /* (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));*/    
        
    $scope.postFb = function(url,name){
        url = "https://scontent.xx.fbcdn.net/v/t1.0-0/s130x130/17799140_1528028767221570_2658424478715429709_n.jpg?oh=cf431486506736c444ed35e7f095a50d&oe=59943DBB";
        
        //FB.init({appId: '265499893903510', status: true, cookie: true, xfbml: true});
        
    };
    
    $scope.back = function()
    {
        $scope.showDetails = false;
        $scope.tableView = true;
        $scope.postToFb = false;
    };
        
    //details function: albums and posts
    $scope.giveDetails = function(id,url)
    {
        window.alert($scope.tab);
        if($scope.tab === "user" || $scope.tab == "event")
        {
            window.alert("inside");
            $scope.albumsData = [];
            $scope.postsData = [];
            $scope.tableView = false;
            $scope.postToFb = true;
            $scope.showDetails = true;
            $scope.nextButton = false;
            $scope.prevButton = false;
            $scope.$apply();
        }
        else
        {
            window.alert(id);
            $.ajax({
        url: 'phpFunctions.php',
        type: 'GET',
        data: {"details":"details","id":id},
        success: function(results,jqXHR){
            console.log(results);
            window.alert(results);
            
            var obj = JSON.parse(results);
            window.alert("obj");
            if(!(obj["albums"]))
            {
                if(!(obj["posts"]))
                {
                    window.alert("no albums and posts visible for this entity...");
                }
            }
            if((obj["albums"]))
            {
                $alb = obj["albums"];
            }
            else
            {
                $alb = new Array();
            }
            if(obj["posts"])
            {
                $pos = obj["posts"];         
            }
            else
            {
                $pos = new Array();
            }
            
            $alb = obj.albums;
            $pos = obj.posts;
            
            window.alert("fine till here: $alb="+$alb);
            $scope.albumsData = $alb;
            $scope.postsData = $pos;
            window.alert("fine till here2:$posts="+$pos);
//            window.alert("alb_len="+$alb.length);
//            window.alert("post_len="+$pos.length);
            
                
            
//            if($alb.length === 0 && $pos.length === 0)
//                {
//                    window.alert("No posts and albums to show!!!");
//                }
//            
            
            //$alb.forEach(function(element) {
            //});
            
            
           
            
            $scope.tableView = false;
            $scope.postToFb = true;
            $scope.showDetails = true;
            $scope.nextButton = false;
            $scope.prevButton = false;
            $scope.$apply();
            
            
        },
        error: function($xhr) {
        var response = $xhr.responseText;
        //console.log(response);
        var statusMessage = $xhr.status + ' ' + $xhr.statusText;
        var message  = 'Query failed, php script returned this status: ';
        var message = $message + $statusMessage + ' response: ' + $response;
        window.alert($message);  
        }
        });  
        }
        
    };    
        
    //update table
    $scope.updateTable = function(results)
    {   
        var obj = JSON.parse(results);
        $scope.fbData = obj.data;
        $scope.nextUrl = obj.next;
        $scope.prevUrl = obj.prev;
        
        $scope.tableView = true;
        $scope.nextButton = true;
        $scope.postToFb = false;
        $scope.showDetails = false;
        $scope.checkPrev();
        $scope.$apply();
    };
        
        
    //clear button logic    
    $scope.clear = function()
    {
        //$scope.count ="yo";
        $scope.checkPrev();
        $scope.tab = "user";
        $scope.keyword = "";
        $scope.$_POST = [];
        $scope.$_GET = [];
        $scope.tableView = false;
        //window.alert("results");
    };
        
        
    //next click    
    $scope.nextClick = function()
    {
        $scope.prevButton = true;
      
        $url = $scope.nextUrl;
        $.ajax({
        url: 'phpFunctions.php',
        type: 'GET',
        data: {'next':"next",'nextUrl':$url},
        success: function(results,jqXHR){
            var statusval = jqXHR;
              $scope.updateTable(results);
            
        },
        error: function($xhr) {
            
        var response = $xhr.responseText;
        //console.log(response);
            window.alert("inside next error!!"+response);
        var statusMessage = $xhr.status + ' ' + $xhr.statusText;
        var message  = 'Query failed, php script returned this status: ';
        var message = $message + $statusMessage + ' response: ' + $response;
        window.alert($message);  
        }
        });  
        //show next page contents
    };
        
    //prev click
    $scope.prevClick = function()
    {
        $url = $scope.prevUrl;
        $.ajax({
        url: 'phpFunctions.php',
        type: 'GET',
        data: {"prev":"prev","prevUrl":$url},
        success: function(results,jqXHR){
            var statusval = jqXHR;
            $scope.updateTable(results);
            $scope.$apply();
        },
        error: function($xhr) {
        var response = $xhr.responseText;
        //console.log(response);
        var statusMessage = $xhr.status + ' ' + $xhr.statusText;
        var message  = 'Query failed, php script returned this status: ';
        var message = $message + $statusMessage + ' response: ' + $response;
        window.alert($message);  
        }
        });  
    };
        
    //progress bar    
    $scope.progressBar = function(yo)
    {
            var inc = 0,
            max = 9999;
            delay = 100; // 100 milliseconds

            function timeoutLoop() {
            var htmlCode = "<div class='progress'><div class='progress-bar' role='progressbar' aria-valuenow='70' aria-valuemin='0' aria-valuemax='100' style='width:"+inc+"%'><span class='sr-only'>70% Complete</span></div></div>";
            document.getElementById('test').innerHTML = htmlCode;
            if (++inc < max)
                {
                    setTimeout(timeoutLoop, delay);
                }  
        }
        setTimeout(timeoutLoop, delay);
    };
});