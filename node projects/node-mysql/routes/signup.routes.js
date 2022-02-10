const SignUpRouter = require("express").Router()
const SignupContr = require('../controller/signup.contr')


SignUpRouter.get('/register',SignupContr.Regpage);

SignUpRouter.post('/AddUser', SignupContr.validation , SignupContr.SignUp);

SignUpRouter.post('/AddGroup', SignupContr.Addgroup)


module.exports = SignUpRouter