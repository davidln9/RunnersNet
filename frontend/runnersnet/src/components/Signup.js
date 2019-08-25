import React from 'react'

class Signup extends React.Component {

    constructor(props) {
        super(props);

        this.state = {
            email: "",
            first_name: "",
            last_name: "",
            gender: ""
        }
    }
    setEmail(email) {
        this.setState({
            email: email
        })
    }

    setFirstName(first_name) {
        this.setState({
            first_name: first_name
        })
    }

    setLastName(last_name) {
        this.setState({
            last_name: last_name
        })
    }

    render() {

        return (
                <div className="main-w3layouts wrapper">
        <h1>Creative SignUp Form</h1>
        <div className="main-agileinfo">
          <div className="agileits-top">
            <form action="#" method="post">
              <input className="text" type="text" name="Username" placeholder="Username" required />
              <input className="text email" type="email" name="email" placeholder="Email" required />
              <input className="text" type="password" name="password" placeholder="Password" required />
              <input className="text w3lpass" type="password" name="password" placeholder="Confirm Password" required />
              <div className="wthree-text">
                <label className="anim">
                  <input type="checkbox" className="checkbox" required />
                  <span>I Agree To The Terms &amp; Conditions</span>
                </label>
                <div className="clear"> </div>
              </div>
              <input type="submit" defaultValue="SIGNUP" />
            </form>
            <p>Don't have an Account? <a href="#"> Login Now!</a></p>
          </div>
        </div>
        {/* copyright */}
        <div className="colorlibcopy-agile">
          <p>© 2018 Colorlib Signup Form. All rights reserved | Design by <a href="https://colorlib.com/" target="_blank">Colorlib</a></p>
        </div>
        {/* //copyright */}
        <ul className="colorlib-bubbles">
          <li />
          <li />
          <li />
          <li />
          <li />
          <li />
          <li />
          <li />
          <li />
          <li />
        </ul>
      </div>
            
        )
    }
}

export default Signup;