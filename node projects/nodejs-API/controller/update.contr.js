const UserModel = require('../models/UserModel.conf')
const bcrypt = require('bcrypt');

module.exports.updatepage = async (req, res) => {
         
        let userprofile = req.username
        let data = await UserModel.find({username : userprofile})
            
    
}

module.exports.edituser = async (req, res) => {
     
        //console.log(req.body);

        const {firstname,lastname,email,password,password2} = req.body

        let userid = req.userid

        if (typeof firstname !== 'undefined' && firstname !='') {
           
            const result = await UserModel.updateOne({ _id: userid }, { $set: { firstname: firstname } });
        }
        if (typeof lastname !== 'undefined' && lastname !='') {
         
            const result = await UserModel.updateOne({ _id: userid }, { $set: { lastname: lastname } });
       
        }
        if (typeof email !== 'undefined' && email !='') {
        
            const result = await UserModel.updateOne({ _id: userid }, { $set: { email: email } });
        
        }
        if (typeof password !== 'undefined' && password !='') {
        
            if (password ==  password2) {

                bcrypt.hash(password, 7, async function(err, hash) {
 
                    await UserModel.updateOne({ _id: userid }, { $set: { password: hash } });

    
                });

            }
        }

        res.json({message:"user updated"})

    
}