const { validationResult } = require('express-validator')
const UserModel = require('../models/UserModel.conf')
const GroupModel = require('../models/GroupModel.conf');
const bcrypt = require('bcrypt');


module.exports.adduser = async (req, res) => {

    const {firstname,lastname,username,email,password,password2,gender} = req.body
    const errors = validationResult(req);
 
    if (!errors.isEmpty()) {
 
     return res.status(400).json({ errors: errors.array() });
     
   }
   else {
 
     let checkemail = await UserModel.findOne({email})
 
     if (checkemail == null){
     
          let checkuser = await UserModel.findOne({username})
          if (checkuser == null){
  
              // insert user code
             
              
              bcrypt.hash(password, 7, async function(err, hash) {
  
                  await UserModel.insertMany({
             
                      firstname: firstname,
                      lastname: lastname,
                      username: username,
                      email: email,
                      password: hash,
                      gender: gender,
              
                  })
                  
  
              });
              
              
              res.json({Message:"user inserted"})
  
          }
          else {
              
            res.json({Message:"user exists"})

          }
     }
     else {
         
        res.json({Message:"email exists"})

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