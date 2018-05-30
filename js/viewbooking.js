      var app = angular.module('AApp', []);
      app.controller('ACtrl', function($scope, $http) {

        $scope.booking = [];
        $scope.booklist = [];

        $scope.bookingdate = [];
        $scope.bookdatelist = [];


        $http.get("include/all_booking.php")
          .then(function (response) {
            $scope.booking = response.data.records;

            for(i=0;i<$scope.booking.length;i++) {
              $scope.booklist.push($scope.booking[i]);
            }
          }, function (response) {
            console.log("couldn't load");
          });
        });