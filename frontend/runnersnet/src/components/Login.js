import React from 'react';
import { connect } from 'react-redux';
import { Link } from 'react-router-dom'

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
      <div className="login-page">
        <div className="form">
          <div className="login-form">
            <input type="email" placeholder="email" onChange={evt => this.setUsername(evt.target.value)} />
            <input type="password" placeholder="password" onChange={evt => this.setPassword(evt.target.value)} />
            <button onClick={() => this.submitForm()}>login</button>
            <p className="message">Not registered? <Link to="/signup">Create an account</Link></p>
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