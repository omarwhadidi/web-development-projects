const UserUpdateRouter = require('express').Router()
const UserUpdateContr = require('../controller/update.contr')
const auth = require('../controller/auth')

UserUpdateRouter.get('/UpdateUserInfo', auth , UserUpdateContr.updatepage);

UserUpdateRouter.post('/EditUser', auth , UserUpdateContr.edituser);

module.exports = UserUpdateRouter 