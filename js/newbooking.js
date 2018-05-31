      var app = angular.module('AApp', []);
      app.controller('ACtrl', function($scope, $http) {

        $scope.guests = [];
        $scope.guestlist = [];

        $scope.rooms = [];
        $scope.roomlist = [];

        $http.get("include/guests_rooms.php")
          .then(function (response) {
            $scope.guests = response.data.guestdata;
            $scope.rooms = response.data.roomdata;

            for(i=0;i<$scope.guests.length;i++) {
              $scope.guestlist.push($scope.guests[i]);
            }
            for(i=0;i<$scope.rooms.length;i++) {
              $scope.roomlist.push($scope.rooms[i]);
            }
          }, function (response) {
            console.log("couldn't load");
          });
        });
