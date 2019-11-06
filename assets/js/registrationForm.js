import $ from 'jquery';

export default function() {
  $().ready(() => {
    let allowSubmit = true;

    const regForm = $('form[name=registration_form]');
    const emailEl = $('input[name="registration_form[email]"]', regForm);

    regForm.submit(() => {
      if (!allowSubmit) {
        return false;
      }
    });

    let t;
    const emailRegEx = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    emailEl.on('input', e => {
      allowSubmit = false;
      if (!emailEl.is(':valid') || !emailRegEx.test(emailEl.val())) {
        setEmailStatus('Email is not valid', 'error');
        return false;
      } else {
        setEmailStatus('Verifying email...', 'info');
      }

      clearTimeout(t);
      t = setTimeout(() => {
        emailExists(emailEl.val()).then(exists => {
          if (exists) {
            setEmailStatus('This e-mail is already registered!', 'error');
          } else {
            setEmailStatus('You can register this e-mail!', 'success');
            allowSubmit = true;
          }
        });
      }, 200);
    });

    let xhr;
    const emailExists = email => {
      return new Promise((resolve, reject) => {
        if (xhr) {
          xhr.abort();
        }

        xhr = $.post(
          '/check_email',
          { email },
          response => {
            resolve(response.status);
          },
          'json'
        )
        .fail(function(response) {
          setEmailStatus('There was an error, while checking the email..., check console', 'error');
        });
      });
    };

    const setEmailStatus = (msg, status) => {
      $('.email-status')
        .html(msg)
        .removeClass()
        .addClass('email-status')
        .addClass(status);
    };
  });
}
