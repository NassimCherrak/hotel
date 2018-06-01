      var app = angular.module('AApp', []);
      app.controller('ACtrl', function($scope, $http) {

        $scope.viewbooking = true;

        $scope.showdateout = true;

        $scope.booking = [];
        $scope.booklist = [];

        $scope.bookingdate = [];
        $scope.bookdatelist = [];

          
        $scope.guests = [];
        $scope.guestlist = [];

        $scope.rooms = [];
        $scope.roomlist = [];

        $scope.currentpage = 1;
        $scope.numofpages = 1;
        $scope.lastpage = true;


        //load current and future booking information
        $http.get("include/all_booking.php")
          .then(function (response) {
            $scope.booking = response.data.records;

            for(i=0;i<$scope.booking.length;i++) {
              $scope.booklist.push($scope.booking[i]);
            }

            $scope.numofpages = response.data.pages;
            $scope.lastpage = ($scope.currentpage == $scope.numofpages) || ($scope.numofpages == 0);
            console.log("current"+$scope.currentpage+" all"+$scope.numofpages);

          }, function (response) {
            console.log("couldn't load");
          });

        //load guest and room names to fill the select options on booking edition
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

        //show one more page of bookings
        $scope.showMore = function() {
          if($scope.currentpage<$scope.numofpages) {
            $scope.currentpage++;
            $http.get("include/all_booking.php?page="+$scope.currentpage)
            .then(function (response) {
              $scope.booking = response.data.records;

              for(i=0;i<$scope.booking.length;i++) {
                $scope.booklist.push($scope.booking[i]);
              }

              $scope.numofpages = response.data.pages;
              $scope.firstpage = ($scope.currentpage == "1");
              $scope.lastpage = ($scope.currentpage == $scope.numofpages);
              console.log("current"+$scope.currentpage+" all"+$scope.numofpages);

            }, function (response) {
              console.log("couldn't load");
            });
          }
        }

          //points out the current booking to edit
          $scope.selectBooking = function(id, guest, room, roomid, datein, dateout) {
            $scope.currentid = id;
            $scope.currentguest = guest;
            $scope.currentroom = room;
            $scope.currentroomid = roomid;
            $scope.currentdatein = datein;
            $scope.currentdateout = dateout;

            $scope.viewbooking = false;
          }

          //update information for deleted booking
          $scope.updateDel = function(id) {
            $scope.bookingdel = id;
            console.log($scope.bookingorder);
          }

          //checkbox to show/hide the option of the second date (date of the end of a booking)
          $scope.toggleShowDateOut = function() {
            $scope.showdateout = !$scope.showdateout;
            if(!$scope.showdateout) {
              $scope.currentdateout = "";
            }
          }
        });

