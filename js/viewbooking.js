      var app = angular.module('AApp', []);
      app.controller('ACtrl', function($scope, $http) {

        $scope.viewbooking = true;

        $scope.booking = [];
        $scope.booklist = [];

        $scope.bookingdate = [];
        $scope.bookdatelist = [];

          
        $scope.guests = [];
        $scope.guestlist = [];

        $scope.rooms = [];
        $scope.roomlist = [];


        $http.get("include/all_booking.php")
          .then(function (response) {
            $scope.booking = response.data.records;

            for(i=0;i<$scope.booking.length;i++) {
              $scope.booklist.push($scope.booking[i]);
            }
          }, function (response) {
            console.log("couldn't load");
          });

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

          $scope.selectBooking = function(id, guest, room, roomid, datein, dateout) {
            $scope.currentid = id;
            $scope.currentguest = guest;
            $scope.currentroom = room;
            $scope.currentroomid = roomid;
            $scope.currentdatein = datein;
            $scope.currentdateout = dateout;

            $scope.viewbooking = false;
          }

          $scope.updateDel = function(id) {
            $scope.bookingdel = id;
          }
        });

