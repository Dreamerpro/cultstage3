angular.module('cultstage')
.controller('VideoController', function ($http, Notification,Upload) {
  var _self=this;
  this.init=function() {
  _self.loaded=false;
    $http.get('/uploaded/videos')
    .success(function(msg) {
      console.log(msg);
      _self.videos=msg;
      _self.loaded=true;
    })
    .error(function(msg) {
      console.log(msg);
      _self.loaded=true;
    })
  }
  this.delete=function(item, index) {
    $http.get('/delete/video/'+item.name)
    .success(function(dt) {   _self.videos.splice(index,1);   })
    .error(function(as) {     console.log(as);Notification.error({message:'Error deleting audio!',replaceMessage:true})   })
  }
  this.upload=function(file) {
    Upload.upload({
        url: '/upload/video',
        data: {file: file}
    }).then(function (resp) {

        console.log('Success ' + resp.config.data.file.name + 'uploaded. Response: ' + resp.config.data);
        Notification.success('Successfully uploaded  video.');
        _self.init();
    }, function (resp) {
        Notification.error('Error uploading video.');
    }, function (evt) {
        var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
        _self.uploadPercentage=progressPercentage;
        if(_self.uploadPercentage==100){_self.uploadPercentage=0;}
        console.log('progress: ' + progressPercentage + '% ' + evt.config.data.file.name);
    });

  }
})
