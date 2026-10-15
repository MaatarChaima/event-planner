"""
Tests Selenium du formulaire de connexion (/login) - Event Planner

Prérequis :
 - serveur Laravel démarré : php artisan serve
 - un compte utilisateur (non administrateur) user@test.com / Password123
   existe déjà (créé via /register)
"""
from selenium import webdriver
from selenium.common.exceptions import TimeoutException
from selenium.webdriver.common.by import By
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.support.ui import WebDriverWait

driver = webdriver.Chrome()

BASE_URL = "http://localhost:8000/login"
HOME_URL = "http://localhost:8000/"


def soumettre(bouton):
    """Clique sur le bouton puis attend que la nouvelle page soit chargée.
    Si le navigateur bloque l'envoi (validation HTML5), la page ne change pas."""
    ancienne_page = driver.find_element(By.TAG_NAME, "html")
    bouton.click()
    try:
        WebDriverWait(driver, 5).until(EC.staleness_of(ancienne_page))
        WebDriverWait(driver, 5).until(
            lambda d: d.execute_script("return document.readyState") == "complete"
        )
    except TimeoutException:
        pass


def login(email, password):
    driver.get(BASE_URL)

    email_input = driver.find_element(By.NAME, "email")
    password_input = driver.find_element(By.NAME, "password")

    email_input.clear()
    password_input.clear()

    email_input.send_keys(email)
    password_input.send_keys(password)

    soumettre(driver.find_element(By.XPATH, "//button[text()='Sign In']"))


def deconnecter():
    # Après une connexion réussie, /login redirigerait vers l'accueil :
    # on supprime les cookies pour revenir à un visiteur non connecté.
    driver.delete_all_cookies()


# -----------------------------
# Classe valide
print("Test 1 : Classe valide")
login("user@test.com", "Password123")
if driver.current_url == HOME_URL:
    print("PASS – Connexion réussie")
else:
    print("FAIL – Connexion échouée")
deconnecter()

# -----------------------------
# Classe invalide 1
print("Test 2 : Email valide + mauvais mot de passe")
login("user@test.com", "wrongpass")
if "login" in driver.current_url:
    print("PASS – Accès refusé")
else:
    print("FAIL – Erreur de sécurité")
deconnecter()

# -----------------------------
# Classe invalide 2
print("Test 3 : Email invalide")
login("abc", "Password123")
if "login" in driver.current_url:
    print("PASS – Email invalide rejeté")
else:
    print("FAIL")
deconnecter()

# -----------------------------
# Classe invalide 3
print("Test 4 : Champs vides")
login("", "")
if "login" in driver.current_url:
    print("PASS – Champs vides rejetés")
else:
    print("FAIL")

driver.quit()
