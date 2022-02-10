const { validationResult } = require('express-validator')
const UserModel = require('../models/UserModel.conf')
const GroupModel = require('../models/GroupModel.conf');
const bcrypt = require('bcrypt');


module.exports.registerpage =  (req, res) => {

    let oldinput = req.flash('oldinput')[0]

    if (oldinput == undefined){
        oldinput = {
            firstname: '',
            lastname: '',
            username: '',
            email: '',
            password: '',
            password2: '',
            submit: ''
          
        } 
    }
    console.log(req.flash('errors'))

    res.render('register.ejs' , {errors : req.flash('errors') , oldinput:oldinput, emailexists: req.flash('emailexists') , userexists: req.flash('userexists')})

}

module.exports.adduser = async (req, res) => {

    const {firstname,lastname,username,email,password,password2,gender} = req.body
    const errors = validationResult(req);
 
    if (!errors.isEmpty()) {
 
     //return res.status(400).json({ errors: errors.array() });
     //console.log(errors.array())
     req.flash('errors', errors.array())
     req.flash('oldinput', req.body)
     res.redirect('/register')
   }
   else {
 
     let checkemail = await UserModel.findOne({email})
 
     if (checkemail == null){
     
          let checkuser = await UserModel.findOne({username})
          if (checkuser == null){
  
              // insert user code
              // console.log('user inserted')
              var ip = req.headers['x-real-ip'] || req.connection.remoteAddress;
              
              bcrypt.hash(password, 7, async function(err, hash) {
  
                  await UserModel.insertMany({
             
                      firstname: firstname,
                      lastname: lastname,
                      username: username,
                      email: email,
                      password: hash,
                      gender: gender,
                      clientip: ip
              
                  })
  
              });
  /* 
              await GroupModel.insertMany({
             
                  username: username,
                  role: 'User',
          
              }) */
              req.flash('inserted' , true)
              res.redirect('/')
  
          }
          else {
              
              //console.log('username exists')
              req.flash('userexists' , true)
              req.flash('oldinput', req.body)
              res.redirect('/register')
          }
     }
     else {
         req.flash('emailexists' , true)
         req.flash('oldinput', req.body)
         //console.log('email exists')
         res.redirect('/register')
     }
 
   }
   
 }

 module.exports.addgroup = async (req, res) => {

    const {username} = req.body
    let usergroup = await  UserModel.findOne({username})
    console.log(usergroup._id)
    await GroupModel.insertMany({

        userid : usergroup._id,
        username: username,
        role: 'User',

    }) 
    res.json({message:"Group Added "})
}