import React from 'react'
import { NavLink } from 'react-router'
import { Link } from 'react-router'

const Header = () => {
  return (
    <>
      <nav className="navbar navbar-expand-lg bg-light">
      <div className="container-fluid">
        <Link to='/' className="navbar-brand" href="#">Task One</Link>
        <button className="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
          <span className="navbar-toggler-icon"></span>
        </button>
        <div className="collapse navbar-collapse" id="navbarNavAltMarkup">
          <div className="navbar-nav">
              <NavLink to='/' className="nav-link" aria-current="page" >Home</NavLink>
              <NavLink to='/about' className="nav-link" aria-current="page">About</NavLink>
          </div>
        </div>
      </div>
    </nav>
    </>
  )
}

export default Header