angular.module('cultstage')
.controller('PhotosController', function ($http, Notification, Upload) {
  var t=this;
  t.photos=[];
  t.init=function () {
    $http.get('/myalbumimages')
    .success(function(resp) {
      t.photos=resp;
    })
    .error(function() {
      console.log('error');
    });
  }

  t.addphoto=function (file) {
    if(t.photos.length<5){
        Upload.upload({
            url: '/upload/albumimage',
            data: {file: file}
        }).then(function (resp) {

            // console.log('Success ' + resp.config.data.file.name + 'uploaded. Response: ' + resp.config.data);
            if(resp.data.name){
              t.photos.push({name:resp.data.name});
              Notification.success('Successfully uploaded image.');
            }


        }, function (resp) {
            console.log('Error status: ' + resp.status);
            Notification.error('Error uploading image.');
        }, function (evt) {
            var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
            // console.log('progress: ' + progressPercentage + '% ' + evt.config.data.file.name);
        });

    }
  }
  t.deletephoto=function(photo) {
    $http.post('/deleteimage',{filename:photo.name,type:4})
    .success(function (resp) {
      t.photos.splice(t.photos.indexOf(photo),1);
    })
    .error(function (resp) {
      Notification.error({message: 'Error deleting photo.', replaceMessage: true});
    })
  }

})
