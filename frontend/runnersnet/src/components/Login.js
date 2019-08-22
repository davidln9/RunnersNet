import React from 'react';
import { connect } from 'react-redux';

import { actions } from '../redux/Users/actions';

const login = actions.login;


class Login extends React.Component {

    constructor(props) {
        super(props);

        this.state = {
            username: "",
            password: ""
        }
    }

    setUsername(username) {
        this.setState({
            username: username
        })
    }

    setPassword(password) {
        this.setState({
            password: password
        })
    }

    submitForm() {
        this.props.dispatch(login(this.state));
    }

    render() {
        console.log(this.props);
        return (
            <div className="register-area ptb-100">
                <div className="container-fluid">
                    <div className="row">
                        <div className="col-md-12 col-12 col-lg-6 col-xl-6 ml-auto mr-auto">
                            <div className="login">
                                <div className="login-form-container">
                                    <div className="login-form">
                                        <input type="email" name="user-name" placeholder="Username" onChange={evt=>this.setUsername(evt.target.value)}/>
                                        <input type="password" name="user-password" placeholder="Password" onChange={evt=>this.setPassword(evt.target.value)}/>
                                        <div className="button-box">
                                            <div className="login-toggle-btn">
                                                <input type="checkbox" />
                                                <label>Remember me</label>
                                                <a href="#">Forgot Password?</a>
                                            </div>
                                            <button type="submit" onClick={()=>this.submitForm()} className="default-btn floatright">Login</button>
                                        </div>
                                    </div>
                                    {this.props.message}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        )
    }
}

function mapStateToProps(state) {
    const loggedin = state.Users.loggedin;
    const message = state.Users.message
    return ({
        loggedin: loggedin,
        message: message
    })
}

export default connect(mapStateToProps)(Login);