describe('Formulaire de création de compte', () => {
    it('test 1 - création de compte ok', () => {
        cy.visit('https://127.0.0.1:8000/register');

        cy.get('#registration_form_email').type('testcy@test.fr');
        cy.get('#registration_form_firstName').type('test');
        cy.get('#registration_form_lastName').type('cypress');
        cy.get('#registration_form_plainPassword_first').type('azerty');
        cy.get('#registration_form_plainPassword_second').type('azerty');
        cy.get('#registration_form_agreeTerms').check();

        // Soumettre le formulaire
        cy.get('button[type="submit"]').click();

        cy.contains('Votre compte a bien été créé. Un email de confirmation vous a été envoyé.').should('exist');
    });

    it('test 1 - création de compte invalid', () => {
        cy.visit('https://127.0.0.1:8000/register');

        cy.get('#registration_form_email').type('test@test.fr');
        cy.get('#registration_form_firstName').type('test');
        cy.get('#registration_form_lastName').type('cypress');
        cy.get('#registration_form_plainPassword_first').type('aze');
        cy.get('#registration_form_plainPassword_second').type('aze');
        cy.get('#registration_form_agreeTerms').check();

        // Soumettre le formulaire
        cy.get('button[type="submit"]').click();

        cy.contains('Votre mot de passe doit contenir au moins 6 caractères').should('exist');
    });
});