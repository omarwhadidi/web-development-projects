const SignInRouter = require('express').Router()
const SignInContr = require('../controller/signin.contr')


SignInRouter.get('/', SignInContr.loginpage);
SignInRouter.post('/signin', SignInContr.signin );



module.exports = SignInRouter