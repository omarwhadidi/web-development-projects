const SignInRouter = require("express").Router()
const SignInContr = require('../controller/signin.contr')


 SignInRouter.post('/SignIn',  SignInContr.SignIn);


module.exports = SignInRouter