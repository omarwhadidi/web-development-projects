const UserModel = require('../models/UserModel.conf')
const GroupModel = require('../models/GroupModel.conf');
const bcrypt = require('bcrypt'); 
const { JsonWebTokenError } = require('jsonwebtoken');
const jwt = require('jsonwebtoken');


module.exports.signin = async (req, res) => {

    const {username,password} = req.body
    
    //console.log(req.body)
    
    let user = await UserModel.findOne({username})
    if (user !== null){
        
        const match = await bcrypt.compare(password, user.password);
        if(match){
            
            let permissions = await GroupModel.findOne({username})
            if (permissions.group_number == 2){
                //  send token
               let token =  jwt.sign({userid:user._id , user:user.username , role:permissions.role } , "omar" , { expiresIn: '20m' })
                res.json({Admin:user.username, JWT : token})
            }
            else {
                //  send token
                let token =  jwt.sign({userid:user._id , user:user.username , role:permissions.role } , "omar" , { expiresIn: '20m' })
                res.json({User:user.username, JWT : token})

            }
                    
        }
        else {
            
            res.json({message:"wrong password"})
        }

    }
    else {
       
        res.json({message:"Username not found"})

    }
    
}