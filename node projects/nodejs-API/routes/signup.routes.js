const SignUpRouter = require('express').Router()
const SignUpContr = require('../controller/signup.contr')
const SignUpValidation = require('../controller/validation/siginup.validation')


SignUpRouter.post('/AddUser', SignUpValidation.validation , SignUpContr.adduser);

SignUpRouter.post('/AddGroup', SignUpContr.addgroup);

module.exports = SignUpRouter
