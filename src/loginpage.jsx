import React from "react";
import "bootstrap/dist/css/bootstrap.min.css";
import "./loginpage.jsx"; 

const SignupPage = () => {
  return (
    <div className="container-fluid vh-100 d-flex align-items-center justify-content-center">
      <div className="row w-75 shadow-lg rounded overflow-hidden" style={{ maxWidth: "900px" }}>
        {/* logo */}
        <div className="col-md-6 d-flex flex-column justify-content-center align-items-center text-white p-4" style={{ backgroundColor: "#3b82f6" }}>
          {/* picture ulit */}
          {/* <img src="picturee" alt="Description" className="img-fluid" /> */}
          <div className="text-center">
            <h2 className="fw-bold mb-3">Efficiency Meets Simplicity in GSO Operations</h2>
            <p className="text-light">Enter your credentials to access</p>
          </div>
        </div>
        
        {/* Right Section */}
        <div className="col-md-6 p-5 d-flex flex-column justify-content-center">
          <h3 className="fw-bold">
            Sign up with <span className="text-primary">Kronos!</span>
          </h3>
          <p className="mb-4">Fill out all required fields.</p>
          <form>
            <div className="row mb-3">
              <div className="col">
                <input type="text" className="form-control" placeholder="First Name" required />
              </div>
              <div className="col">
                <input type="text" className="form-control" placeholder="Last Name" required />
              </div>
            </div>
            <div className="row mb-3">
              <div className="col">
                <select className="form-control" required>
                  <option>Department</option>
                  <option>GCC</option>
                </select>
              </div>
              <div className="col">
                <select className="form-control" required>
                  <option>Position</option>
                  <option>Faculty</option>
                </select>
              </div>
            </div>
            <div className="mb-3">
              <input type="text" className="form-control" placeholder="Phone Number" required />
            </div>
            <div className="mb-3">
              <input type="email" className="form-control" placeholder="Email Address" required />
            </div>
            <div className="mb-3">
              <input type="password" className="form-control" placeholder="Password" required />
            </div>
            <div className="mb-3">
              <input type="password" className="form-control" placeholder="Confirm Password" required />
            </div>
            <div className="mb-3 form-check">
              <input type="checkbox" className="form-check-input" id="termsCheck" required />
              <label className="form-check-label" htmlFor="termsCheck">
                I agree to the <a href="#">Terms & Policies</a>
              </label>
            </div>
            <button type="submit" className="btn btn-primary w-100 py-2">
              Sign Up
            </button>
          </form>
          <p className="mt-3 text-center">
            Already have an account? <a href="#">Login</a>
          </p>
        </div>
      </div>
    </div>
  );
};


export default SignupPage;
