const UserModel = require('../models/UserModel.conf')
const PostModel = require('../models/PostModel.conf')
const GroupModel = require('../models/GroupModel.conf')
 

module.exports.adminpage = async(req, res) => {
    
    if (req.session.IsLoggedIn && req.session.IsAdmin){
        
        let data = await PostModel.find().sort({post:1})
        let sessiondata = req.session

        res.render('admin/admin.ejs' , {data , sessiondata})
    }
    else {
        res.redirect('/')
    }
    

}

module.exports.dashboardpage = async (req, res) => {
    
    if (req.session.IsLoggedIn && req.session.IsAdmin){
        
        let data = await GroupModel.find().populate('userid')
        let sessiondata = req.session

        res.render('admin/dashboard.ejs' , {data , sessiondata})
    }
    else {
        res.redirect('/')
    }

}

module.exports.upgradeuser = async(req, res) => {
    
    if (req.session.IsLoggedIn && req.session.IsAdmin){
        
        let name = req.body.username;
        const result = await GroupModel.updateOne({ username: name }, { $set: {group_number: 1, role: "Moderator" } });
        
        res.redirect('/dashboard')
    }
    else {
        res.redirect('/')
    }
    

}

module.exports.downgradeuser = async(req, res) => {
    
    if (req.session.IsLoggedIn && req.session.IsAdmin){
        
        let name = req.body.username;
        const result = await GroupModel.updateOne({ username: name }, { $set: {group_number: 0, role: "User" } });
        

        res.redirect('/dashboard')
    }
    else {
        res.redirect('/')
    }
    

}

module.exports.activateuser = async(req, res) => {
    
    if (req.session.IsLoggedIn && req.session.IsAdmin){
        
        let id = req.body.userid;
        const result = await UserModel.updateOne({ _id: id }, { $set: { regstatus: 1 } });

        res.redirect('/dashboard')
    }
    else {
        res.redirect('/')
    }
}

module.exports.deactivateuser = async(req, res) => {
    
    if (req.session.IsLoggedIn && req.session.IsAdmin){
        
        let id = req.body.userid;
        const result = await UserModel.updateOne({ _id: id }, { $set: { regstatus: '0' } });
        
        res.redirect('/dashboard')
    }
    else {
        res.redirect('/')
    }
    

}

module.exports.deleteuser = async(req, res) => {
    
    if (req.session.IsLoggedIn && req.session.IsAdmin){

        let id = req.body.userid;
        
        await UserModel.deleteOne({ _id : id})
        await GroupModel.deleteOne({ userid : id})

        res.redirect('/dashboard')
    }
    else {
        res.redirect('/')
    }
    

}