import React from 'react'
import { Link } from 'react-router-dom'
import { connect } from 'react-redux';

import { actions } from '../redux/Users/actions'

const { register } = actions

class Signup extends React.Component {

  constructor(props) {
    super(props);

    this.state = {
      email: "",
      first_name: "",
      last_name: "",
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

  submitForm() {
    this.props.dispatch(register(this.state))
  }

  render() {

    return (
      <div className="login-page">
        <div className="form">
          <div className="login-form">
            <input type="text" placeholder="first name" />
            <input type="text" placeholder="last name" />
            <input type="text" placeholder="email address" />
            <button onClick={()=>this.submitForm()}>create</button>
            <p className="message">Already registered? <Link to="/login">Log in</Link></p>
          </div>
        </div>
      </div>
    )
  }
}

function mapStateToProps(state) {
  return state
}

export default connect(mapStateToProps)(Signup)