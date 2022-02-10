const query = require('../db/db.conf.js')   // include database file




module.exports.adminpage = (req,res) => {

    if(req.session.isLoggedIn && req.session.isAdmin){

        let sessiondata = req.session

        query.execute(`select * FROM posts order by Date DESC`, (err,data) => {
    
            res.render("admin/dashboard.ejs",{data,sessiondata})
        }) 

    }    
    else {
        res.redirect('/')
    }
    
    
}

module.exports.dashboard = (req,res) => {
    
    if(req.session.myID && req.session.isAdmin ==true){

        let sessiondata = req.session

        query.execute(`select * FROM users `, (err,data) => {

                res.render("admin/admin.ejs",{data,sessiondata})
           
        }) 

    }   
    else {
        res.redirect('/')
    }
    

}

module.exports.addpost = module.exports.addpost = (req,res) => {
    console.log(req.body);
    let sessiondata = req.session
    let post = req.body.userpost;
    query.execute(`INSERT INTO posts (username,post) VALUES ('${sessiondata.username}','${post}')`) 
    
    res.json({message: "Post Added Successfully"})
    //res.render("home.ejs",{data,sessiondata})
}

module.exports.deletepost = (req,res) => {
    console.log(req.body);
    let id = req.body.postid ;
    query.execute(`DELETE FROM posts where post_id = '${id}' `) 
    
    //res.json({message: "post Deleted Successfully"})
    res.redirect('/admin')
}

module.exports.getusersdetails = (req, res) => {

    query.execute(`select * FROM users `, (err, data) => {

        //res.json(data)
        res.render("admin/admin.ejs", { data })
    })

}

module.exports.getuserdetails = (req, res) => {

    query.execute(`select * FROM users WHERE username = '${req.params.user}'`, (err, data) => {

        res.json(data)
    })


}

module.exports.upgradeuser = (req, res) => {
    console.log(req.body);
    let name = req.body.username;
    query.execute(`UPDATE groups SET group_id = 1 , permissions='Moderator' WHERE username = '${name}' `)

    //res.json({message: "User  updated Successfully"})
    res.redirect('/admin')
}

module.exports.downgradeuser = (req, res) => {
    console.log(req.body);
    let name = req.body.username;
    query.execute(`UPDATE groups SET group_id = 0 , permissions='User' WHERE username = '${name}' `)

    //res.json({message: "User  updated Successfully"})
    res.redirect('/admin')
}

module.exports.activateuser = (req, res) => {
    console.log(req.body);
    let id = req.body.userid;
    query.execute(`UPDATE users SET Regstatus = 1 WHERE id = '${id}' `)

    //res.json({message: "User  updated Successfully"})
    res.redirect('/admin')
}

module.exports.deactivateuser = (req, res) => {
    console.log(req.body);
    let id = req.body.userid;
    query.execute(`UPDATE users SET Regstatus = 0 WHERE id = '${id}' `)

    //res.json({message: "User  updated Successfully"})
    res.redirect('/admin')
}

module.exports.deleteuser  =(req, res) => {
    console.log(req.body);
    let id = req.body.userid;
    query.execute(`DELETE FROM users where id = '${id}' `)

    res.redirect('/admin')
}

