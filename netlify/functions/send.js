const nodemailer = require("nodemailer");

exports.handler = async (event) => {
  const { name, phone, email, message } = JSON.parse(event.body);
  let transporter = nodemailer.createTransport({
    host: process.env.SMTP_HOST,
    port: process.env.SMTP_PORT,
    auth: { user: process.env.SMTP_USER, pass: process.env.SMTP_PASS },
  });
  await transporter.sendMail({
    from: `${name} <${email}>`,
    to: process.env.MAIL_TO,
    subject: "Nowa wiadomość z formularza",
    html: `<p><strong>Imię:</strong> ${name}</p>
           <p><strong>Telefon:</strong> ${phone}</p>
           <p><strong>Mail:</strong> ${email}</p>
           <p><strong>Wiadomość:</strong><br>${message}</p>`,
  });
  return { statusCode: 200, body: "OK" };
};