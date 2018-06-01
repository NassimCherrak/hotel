      var app = angular.module('AApp', []);
      app.controller('ACtrl', function($scope, $http) {

        $scope.datares = [];

        $scope.guests;
        $scope.past;
        $scope.current;
        $scope.future;

        // load statistic information
        $http.get("include/stats.php")
          .then(function (response) {
            $scope.datares = response.data.records;
            if($scope.datares.length == 1) {
              $scope.guests = parseInt($scope.datares[0]['guests']);
              $scope.past = parseInt($scope.datares[0]['past']);
              $scope.current = parseInt($scope.datares[0]['current']);
              $scope.future = parseInt($scope.datares[0]['future']);
            }
          }, function (response) {
            console.log("couldn't load");
          });
        });