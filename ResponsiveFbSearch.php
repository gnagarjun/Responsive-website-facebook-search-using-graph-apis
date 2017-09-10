<!DOCTYPE html>
<html ng-app="searchApp"  ng-controller="mainCtrl" ng-init="tab='user';id=0;fbData='no data';detailsData='no-data';count=1;prevButton=false;tableView=false;nextButton=false;nextUrl='no-data';prevUrl='no-data';detailsFlag=false;postToFbpicUrl='no-data';fbPost='fbpostName';postsData='no-data';albumsData='no-data';showDetails=false;currentDetails='current';currentUrl=''" class="container-fluid"  lang="en">
<head>
  <title>Facebook search example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.5.0-beta.2/angular-sanitize.js"></script>
  <script src="controllerCode.js" type="text/javascript"></script>
    
</head>
<body>
    
    <div class="row" ng-show="postToFb">
                <div class="col-sm-6">  
                    <a href="" class="btn btn-default btn-sm" ng-click="back()">
                    <span class="glyphicon glyphicon-chevron-left"></span> Back
                    </a>
                </div>
                <div class="col-sm-6">  
                    <a href="" class="btn btn-default btn-sm" ng-click="postFbFunc()">
                    <span class="glyphicon glyphicon-chevron-left"></span> fb
                    </a>
                </div>
                
<!--
                <div class="col-sm-6">
                    <div class="pull-right">
                        <img src="http://cs-server.usc.edu:45678/hw/hw8/images/facebook.png" width="20" height="20" ng-click="postFb()"/>
                    </div>
                </div>
-->
        </div>
    
    
        <div class = "form-group">
            <div class="row" style="background-color:#F8F8F8;">
            <div class="col-sm-3" style="color:#3b5998;padding:6px;"><span style="margin-left:42px">FB Search</span></div>
            <div class="col-sm-6">
            <form method= "post"  onsubmit="event.preventDefault();" action="">   
                <div class="row" style="padding:6px">
                    <div class="col-xs-8"><span><input class="form-control" ng-model="keyword" type="text" name = "keyword" placeholder="type something..." required></span></div>
                    <div class="col-sm-2" style="text-align:center;padding:6px;">
                       <button type="submit"  class="btn btn-block btn-success" name = "submit" style="background-color:#3b5998;color:white"  ng-click="buttonClick(tab)">search</button>
                    </div>
                    <div class="col-sm-2" style="text-align:center;padding:6px;">
                        <button class="btn btn-block btn-success" style="background-color:white;color:#3b5998" ng-click = "clear()">clear</button>
                    </div>
                </div>
            </form>
            </div>
            <div class="col-sm-3" ></div>
              <ul class="nav nav-tabs nav-justified" style="width:100%" >
                  <li ng-click = tabClick("user") class="active"><a data-toggle="tab" href="#users">Users</a></li>
                  <li ng-click = tabClick("page")><a data-toggle="tab"  href="#pages">Pages</a></li>
                  <li ng-click = tabClick("event")><a data-toggle="tab" href="#events">Events</a></li>
                  <li ng-click = tabClick("place")><a data-toggle="tab" href="#places">Places</a></li>
                  <li ng-click = tabClick("group")><a data-toggle="tab" href="#groups">Groups</a></li>
                  <li ng-click = tabClick("favorites")><a data-toggle="tab" href="#favorites">Favorites</a></li>
              </ul>
<!--
              <div class="tab-content">
                  <div id="users" class="tab-pane fade in active">users tab</div>
                  <div id="pages" class="tab-pane fade">pages tab</div>
                  <div id="events" class="tab-pane fade">events tab</div>
                  <div id="places" class="tab-pane fade">places tab</div>
                  <div id="groups" class="tab-pane fade">groups tab</div>
                  <div id="favorites" class="tab-pane fade">favorites tab</div>
              </div>
-->
              </div> 
</div>
    <div> 
    <div class="container-fluid" ng-show="tableView"> 
             <div class="table-responsive">  
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Profile photo</th>
                        <th>Name</th>
                        <th>Favorite</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody ng-repeat="data in fbData">
                   <tr>
                        <td>{{1+$index}}</td>
                        <td><img style="width:30px;height:30px;" ng-src="{{data['picture']['data']['url']}}"></td>
                        <td>{{data.name}}</td>
                        <td> <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-star-empty"></i></button></td>
                        <td ><button class="btn btn-default" type="submit" ng-click=giveDetails(data.id,data.picture.data.url)><i class="glyphicon glyphicon-chevron-right"></i></button></td>
                    </tr>
                </tbody>
            </table>
    </div>
        </div>
        <div class="row container-fluid" align="center">
            <div class="col-sm-3"></div>
            <div class="col-sm-3" ng-show="prevButton" > 
                <button id="prev" name="prev" class="btn btn-primary" ng-click="prevClick()">Prev</button> 
            </div>
            <div class="col-sm-3" ng-show="nextButton"> 
                <button id="next" name="next" class="btn btn-primary" ng-click="nextClick()">Next</button> 
            </div>
            <div class="col-sm-3"></div>
            </div>
    </div>
    
    <div class="row container-fluid"  ng-show="showDetails">
        <div class="col-sm-6">
            <div class="panel-group">
                <div class="panel panel-default text-center">
                        <div class="panel-heading">
                            <a data-toggle="collapse" href="#albumsCollapse">Albums</a>
                        </div>
                        <div id="albumsCollapse" class="panel-collapse collapse">                    
                            <div class="panel-body" ng-repeat="data in albumsData">
                                <a href="">{{data.name}}</a>
                            </div>
                        </div>
                </div>
            </div> 
        </div>
        <div class="col-sm-6">
            <div class="container">
                <div class="panel panel-default">
                    <div class="panel-heading">Posts</div>
                    <div class="panel-body" ng-repeat = "data in postsData">{{data.message}}</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>