const UserRouter = require('express').Router()
const UserContr = require('../controller/user.contr')



UserRouter.get('/home', UserContr.homepage);

UserRouter.get('/profile', UserContr.profilepage);


UserRouter.get('/searchpost', UserContr.searchpost);

UserRouter.post('/AddPost', UserContr.addpost);

UserRouter.post('/DeleteUserPost', UserContr.deletepost);

UserRouter.post('/logout', UserContr.logout);



module.exports = UserRouter