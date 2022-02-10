const UserModel = require('../models/UserModel.conf')
const bcrypt = require('bcrypt');

module.exports.updatepage = async (req, res) => {
    
    if (req.session.IsLoggedIn){
        
        let sessiondata = req.session
        let userprofile = sessiondata.username
        let data = await UserModel.find({username : userprofile})
        
        res.render('update.ejs' , {data , sessiondata , updated:req.flash('updated')})
    }
    else {
        res.redirect('/')
    }
    
}

module.exports.edituser = async (req, res) => {
    
    if(req.session.IsLoggedIn){
     
        console.log(req.body);

        const {firstname,lastname,email,password,password2} = req.body

        let usersession = req.session.UserId

        if (typeof firstname !== 'undefined' && firstname !='') {
           
            const result = await UserModel.updateOne({ _id: usersession }, { $set: { firstname: firstname } });
        }
        if (typeof lastname !== 'undefined' && lastname !='') {
         
            const result = await UserModel.updateOne({ _id: usersession }, { $set: { lastname: lastname } });
       
        }
        if (typeof email !== 'undefined' && email !='') {
        
            const result = await UserModel.updateOne({ _id: usersession }, { $set: { email: email } });
        
        }
        if (typeof password !== 'undefined' && password !='') {
        
            if (password ==  password2) {

                bcrypt.hash(password, 7, async function(err, hash) {
 
                    await UserModel.updateOne({ _id: usersession }, { $set: { password: hash } });

    
                });

            }
        }

        req.flash('updated' , true)
        res.redirect('/UpdateUserInfo')

    }
    else {
        res.redirect('/')
    }
    
}