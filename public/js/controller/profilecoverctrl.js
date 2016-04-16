angular.module('cultstage')
.controller('ProfileCoverCtrl', function (Upload, CookieService ,$rootScope, Notification) {
  var t=this;
  this.uData={};

  this.init=function() {
    t.uData=$rootScope.userData;
    console.log(t.uData.avatar);
  }
  this.upload = function (file) {
       Upload.upload({
           url: '/upload/profileimage',
           data: {file: file}
       }).then(function (resp) {

           console.log('Success ' + resp.config.data.file.name + 'uploaded. Response: ' + resp.config.data);
           CookieService.set('avatar', resp.data.avatar);
           $rootScope.updateUserStatus();
           t.uData=$rootScope.userData;
           console.log(t.uData);
           $("#change-profile-modal").modal('hide');
           Notification.success('Successfully changed profile picture.');
       }, function (resp) {
           console.log('Error status: ' + resp.status);
           Notification.error('Error changing profile picture.');
       }, function (evt) {
           var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
           console.log('progress: ' + progressPercentage + '% ' + evt.config.data.file.name);
       });
   };
})
