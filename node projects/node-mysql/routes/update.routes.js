const UpdateRouter = require("express").Router()
const query = require('../db/db.conf.js')   // include database file
const UpdateContr = require('../controller/update.contr') 


UpdateRouter.get('/UpdateUserInfo', UpdateContr.updatepage)

UpdateRouter.post('/EditUser', UpdateContr.edituserinfo)



module.exports = UpdateRouter