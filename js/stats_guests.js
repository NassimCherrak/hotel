      var app = angular.module('AApp', []);
      app.controller('ACtrl', function($scope, $http) {

        $scope.viewlist = true;

        $scope.currentguest = "";
        $scope.currentnum = "";

        $scope.guests = [];
        $scope.guestlist = [];

        $scope.guestbooking = [];
        $scope.guestbookinglist = [];

        $scope.viewlist = true;
        $http.get("include/booking_by_guest.php")
          .then(function (response) {
            $scope.guests = response.data.records;

            for(i=0;i<$scope.guests.length;i++) {
              $scope.guestlist.push($scope.guests[i]);
            }
          }, function (response) {
            console.log("couldn't load");
          });

          $scope.userInfo = function(id, name, num) {
            $scope.viewlist = false;
            $scope.currentguest = name;
            $scope.currentnum = num;
            $http.get("include/user.php?id="+id)
            .then(function (response) {
              $scope.guestbooking = response.data.records;

              for(i=0;i<$scope.guestbooking.length;i++) {
                $scope.guestbookinglist.push($scope.guestbooking[i]);
              }
            }, function (response) {
              console.log("couldn't load");
            });
          }
        });

