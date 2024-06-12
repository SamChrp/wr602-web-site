describe('Formulaire de Connexion', () => {
    it('test 1 - connexion OK', () => {
        cy.visit('https://127.0.0.1:8000/login');

        // Entrer le nom d'utilisateur et le mot de passe
        cy.get('#username').type('samcherpin@gmail.com');
        cy.get('#password').type('azeaze');

        // Soumettre le formulaire
        cy.get('button[type="submit"]').click();

        // Vérifier que l'utilisateur est connecté
        cy.contains('Bienvenue Sam Cherpin !').should('exist');
    });

    it('test 2 - connexion KO', () => {
        cy.visit('https://127.0.0.1:8000/login');

        // Entrer un nom d'utilisateur et un mot de passe incorrects
        cy.get('#username').type('test@test.fr');
        cy.get('#password').type('azeezaeaze');

        // Soumettre le formulaire
        cy.get('button[type="submit"]').click();

        // Vérifier que le message d'erreur est affiché
        cy.contains('Invalid credentials.').should('exist');
    });
});