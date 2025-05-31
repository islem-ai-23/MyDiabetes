const express = require('express');
const passport = require('passport');
const GoogleStrategy = require('passport-google-oauth20').Strategy;

const app = express();

// Configurer Passport
passport.use(new GoogleStrategy({
    clientID: 'TON_CLIENT_ID',
    clientSecret: 'TON_CLIENT_SECRET',
    callbackURL: "/auth/google/callback"
  },
  function(accessToken, refreshToken, profile, done) {
    // ici tu gères l’utilisateur (enregistrement, session, etc.)
    return done(null, profile);
  }
));

app.use(passport.initialize());

// Routes d'authentification
app.get('/auth/google',
  passport.authenticate('google', { scope: ['profile', 'email'] })
);

app.get('/auth/google/callback',
  passport.authenticate('google', { failureRedirect: '/login' }),
  function(req, res) {
    res.redirect('/dashboard');
  }
);

app.listen(3000, () => console.log('Serveur démarré sur http://localhost:3000'));
