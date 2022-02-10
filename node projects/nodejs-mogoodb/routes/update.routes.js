const UserUpdateRouter = require('express').Router()
const UserUpdateContr = require('../controller/update.contr')


UserUpdateRouter.get('/UpdateUserInfo', UserUpdateContr.updatepage);

UserUpdateRouter.post('/EditUser', UserUpdateContr.edituser);

module.exports = UserUpdateRouter 