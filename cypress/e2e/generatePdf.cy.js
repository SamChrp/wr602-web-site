describe('Formulaire de convertion de pdf', () => {

    it('test 1 - convertion pdf', () => {
        cy.visit('https://127.0.0.1:8000/login');

        // Entrer le nom d'utilisateur et le mot de passe
        cy.get('#username').type('samcherpin@gmail.com');
        cy.get('#password').type('azeaze');

        // Soumettre le formulaire
        cy.get('button[type="submit"]').click();

        // Vérifier que l'utilisateur est connecté
        cy.contains('Bienvenue Sam Cherpin !').should('exist');
        cy.visit('https://127.0.0.1:8000/generate/pdf');

        cy.get('#generate_pdf_url').type('https://www.cypress.io');

        cy.get('button[type="submit"]').click();

        cy.contains('Le PDF a été généré avec succès. Vous pouveez maintenant le retrouver dans la rebruique "Historique".').should('exist');
    });
});