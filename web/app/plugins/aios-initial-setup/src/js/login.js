const replaceElementTag = (node,name) => {
  const renamed = document.createElement(name)
  
  for(let i = 0, l = node.attributes.length; i < l; ++i){
    const nodeName  = node.attributes.item(i).nodeName,
      nodeValue = node.attributes.item(i).nodeValue
  
    renamed.setAttribute(nodeName, nodeValue)
  }

  renamed.innerHTML = node.innerHTML

  return node.parentNode.replaceChild(renamed, node)
}

const isLoginFormDirty = (username, password, hasRobot = false, robot = '') => {
  if (hasRobot !== false) {
    return username !== '' && password !== '' && robot !== ''
  } else {
    return username !== '' && password !== ''
  }
}

const isCaptchaChecked = () => {
  return grecaptcha && grecaptcha.getResponse().length !== 0
}

document.addEventListener('DOMContentLoaded', () => {
  const login = document.getElementById('login'),
    loginTitle = document.getElementsByTagName('h1'),
    loginForm = document.getElementsByTagName('form'),
    nav = document.getElementById('nav'),
    backToBlog = document.getElementById('backtoblog'),
    backToBlogBtn = backToBlog !== null ? backToBlog.querySelector('a') : null,
    submitBtn = document.getElementById('wp-submit'),
    userPassLabel = document.querySelector('label[for="user_pass"]'),
    userLoginLabel = document.querySelector('label[for="user_login"]'),
    inputUsername = document.getElementById('user_login'),
    inputPassword = document.getElementById('user_pass')
  
  // Add body class
  document.getElementsByTagName('body')[0].classList.add(login_object['is_tdp'] ? 'reduxlabs' : 'agentimage')
  
  // Append container
  login.insertAdjacentHTML('beforebegin', '<div id="wrapper"></div>')
  
  // Change form title
  if (loginTitle.length > 0) {
    const loginFormName = loginForm.length > 0 ? loginForm[0].getAttribute('name') : 'confirm'
    let loginFormTitle
  
    switch(loginFormName) {
      case 'lostpasswordform':
        loginFormTitle = 'Trouble Logging In?'
        break
      case 'confirm':
        loginFormTitle = 'Trouble Logging In?'
        break
      case 'resetpassform':
        loginFormTitle = 'Reset Your Password'
        break
      case 'admin-email-confirm-form':
        loginFormTitle = 'Administration Email Verification'
        break
      default:
        loginFormTitle = 'Sign In To Your Website Dashboard'
    }
  
    if ( loginTitle[1] !== undefined ) {
      loginTitle[1].innerHTML = loginFormTitle
    } else {
      loginTitle[0].innerHTML = loginFormTitle
    }
  }
  
  // Append cover and login form
  const wrapper = document.getElementById('wrapper')
  wrapper.insertAdjacentHTML('afterbegin', `<div id="cover-photo"><span class="cover-photo-logo ai-font-${login_object['is_tdp'] ? 'reduxlabs-longform' : 'agentimage-logo'}"></span></div>`)
  wrapper.append(login)
  
  // Text change for username label
  if (userLoginLabel !== null) {
    userLoginLabel.firstChild.nodeValue = "Username or E-mail Address"
    
    if (inputUsername !== null) {
      inputUsername.placeholder = "Username or E-mail Address"
    }
  }
  
  // Text change for password label
  if (inputPassword !== null) {
    inputPassword.placeholder = "Password"
  }
  
  if (login_object['action'] === null || login_object['action'] === 'confirm') {
    // Append forgot password
    if (nav !== null && login_object['action'] !== 'confirm') {
      nav.querySelector("a").innerHTML = "Forgot Password?"
      
      if (login_object['is_tdp']) {
        userPassLabel.parentNode.append(nav)
      } else {
        userPassLabel.append(nav)
      }
    }
  
    // Refactor old version of login page to the latest one
    if (userPassLabel !== null && userPassLabel.parentNode.tagName === 'P') {
      // Add class to wrapper
      userPassLabel.parentNode.classList.add('user-pass-wrap')
      
      // Insert div
      userPassLabel.insertAdjacentHTML('afterend', "<div class=\"wp-pwd\"></div>")
      
      // Append input to created div
      const pwdContainer =document.querySelector('.wp-pwd'),
        pwdInput = document.getElementById('user_pass')
      
      pwdContainer.append(pwdInput)
      
      // replace element tag from p to div
      replaceElementTag(userPassLabel.parentNode, 'div')
    }
  
    // Text change
    if (submitBtn !== null) {
      submitBtn.value = 'Login to my account'
      submitBtn.classList.add('hide')
      submitBtn.insertAdjacentHTML('afterend', '<button type="submit" id="wp-submit-btn">Login to my account ' + (login_object['is_tdp'] ? '<span class="ai-font-arrow-i-n"></span>' : '') + '</button>')
    }
    
    if (backToBlogBtn !== null) {
      backToBlogBtn.innerHTML = 'Return to main page'
    }
  } else if (login_object['action'] === 'confirm') {
    // Text Change
    if (backToBlogBtn !== null) {
      backToBlogBtn.innerHTML = 'Return to main page'
    }
    // nav.remove()
  } else {
    // Text Change
    if (backToBlogBtn !== null) {
      backToBlogBtn.href = login_object['url']
      backToBlogBtn.innerHTML = 'Return to login page'
    }
    
    nav.remove()
  }
  
  // Disable submit btn
  if (submitBtn !== null) {
    const submitBtnAlt = document.getElementById('wp-submit-btn')
  
    submitBtn.disabled = true
    
    if (submitBtnAlt !== null) {
      submitBtnAlt.disabled = true
    }
  }
  
  // Append powered by AI/TDP
  backToBlog.insertAdjacentHTML('afterend', `<p id="powered-by">Powered by <a href="" target="_blank">Agent Image</a></p>`)
})

window.addEventListener('load', () => {
  // Render recaptcha
  const recaptcha = document.getElementById('g-recaptcha'),
    recaptchaIsV3 = recaptcha !== null ? Number(recaptcha.dataset['version']) === 3 : null
  
  if (recaptcha !== null) {
    // Check if captcha version 3
    if (Number(recaptcha.dataset['version']) === 3) {
      grecaptcha.execute(recaptcha.dataset['sitekey']).then((token) => {
        recaptcha.value = token
      })
    } else {
      grecaptcha.render('g-recaptcha', {
        'siteKey': recaptcha.dataset['sitekey']
      })
    }
  }
  
  // Add event listener to the form if is dirty
  const loginForm = document.getElementsByTagName('form'),
    submitBtn = document.getElementById('wp-submit')
  
  if (loginForm.length > 0) {
    // Form Name
    const loginFormName = loginForm[0].getAttribute('name')
    
    if (loginFormName === 'lostpasswordform') {
      // Lost password page
      const inputUsername = document.getElementById('user_login')
      
      inputUsername.addEventListener('keyup', () => {
        const submitBtnAlt = document.getElementById('wp-submit-btn')
        
        submitBtn.disabled = inputUsername.value === ''
        if (submitBtnAlt !== null) {
          submitBtnAlt.disabled = inputUsername.value === ''
        }
      })
    } else if (loginFormName === 'resetpassform') {
      // Reset password page
      const inputPass = document.getElementById('pass1'),
        inputPassIsWeak = document.getElementById('pw-weak')
  
      inputPass.addEventListener('keyup', () => {
        submitBtnEnabler()
      })
  
      inputPassIsWeak.addEventListener('keyup', () => {
        submitBtnEnabler()
      })
      
      const submitBtnEnabler = () => {
        const submitBtnAlt = document.getElementById('wp-submit-btn')
  
        if (inputPass.classList.contains('short')) {
          submitBtn.disabled = inputPass.value === '' || ! inputPassIsWeak.checked
    
          if (submitBtnAlt !== null) {
            submitBtnAlt.disabled = inputPass.value === '' || ! inputPassIsWeak.checked
          }
        } else {
          submitBtn.disabled = inputPass.value === ''
    
          if (submitBtnAlt !== null) {
            submitBtnAlt.disabled = inputPass.value === ''
          }
        }
      }
    } else {
      // Login page
      const inputUsername = document.getElementById('user_login'),
        inputPassword = document.getElementById('user_pass'),
        inputs = document.querySelectorAll('input:not(#wp-submit):not([type=hidden])')
      
      const submitBtnEnabler = () => {
        const inputRobot = document.getElementById('session_token'),
          submitBtnAlt = document.getElementById('wp-submit-btn')
  
        let robotValue =
          inputRobot !== null
            ? (inputRobot.checked ? 'checked' : '')
            : (
              recaptcha !== null
                ? (
                  recaptchaIsV3
                    ? recaptcha.value
                    : isCaptchaChecked() ? 'checked' : ''
                )
                : false
            )
  
        submitBtn.disabled = ! isLoginFormDirty(inputUsername.value, inputPassword.value, robotValue !== false, robotValue)
  
        if (submitBtnAlt !== null) {
          submitBtnAlt.disabled = ! isLoginFormDirty(inputUsername.value, inputPassword.value, robotValue !== false, robotValue)
        }
      }
      
      // Add event listener for input type text and checkbox
      // Enable submit btn
      inputs.forEach(input => {
        if (input.getAttribute('type') === 'checkbox') {
          input.addEventListener('change', () => {
            submitBtnEnabler()
          }, false)
        } else {
          input.addEventListener('keyup', () => {
            submitBtnEnabler()
          }, false)
        }
      })
    }
  }
})

