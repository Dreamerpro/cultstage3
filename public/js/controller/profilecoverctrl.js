angular.module('cultstage')
.controller('ProfileCoverCtrl', function (Upload, CookieService ,$rootScope, Notification) {
  var t=this;
  this.uData={};
  this.uploadPercentage=[0,0];

  this.init=function() {
    t.uData=$rootScope.userData;
    console.log(t.uData.avatar);
  }
  this.upload = function (file,what) {
      var url=['/upload/profileimage','/upload/coverimage'];
      var msg=['profile','cover'];
       Upload.upload({
           url: url[what],
           data: {file: file}
       }).then(function (resp) {

           console.log('Success ' + resp.config.data.file.name + 'uploaded. Response: ' + resp.config.data);
           if(what==0){CookieService.set('avatar', resp.data.avatar);}
           else{CookieService.set('cover', resp.data.cover);}
           $rootScope.updateUserStatus();
           t.init();
           Notification.success('Successfully changed '+msg[what]+' picture.');
       }, function (resp) {
           //console.log('Error status: ' + resp.status);
           Notification.error('Error changing '+msg[what]+' picture.');
       }, function (evt) {
           var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
           t.uploadPercentage[what]=progressPercentage;
           if(t.uploadPercentage[what]==100){t.uploadPercentage[what]=0;}
           console.log('progress: ' + progressPercentage + '% ' + evt.config.data.file.name);
       });
   };
})
