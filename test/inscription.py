"""
Tests Selenium du formulaire d'inscription (/register) - Event Planner
 - classes d'équivalence (CV1, CI1..CI6)
 - valeurs limites (name, email, password)

Prérequis :
 - serveur Laravel démarré : php artisan serve
 - base de test : les comptes créés par une exécution précédente doivent être
   supprimés avant de relancer (les adresses des valeurs limites de l'email,
   ex. "e@t.fr", sont fixes et seraient refusées comme "déjà existantes").
"""
import time

from selenium import webdriver
from selenium.common.exceptions import TimeoutException
from selenium.webdriver.common.by import By
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.support.ui import WebDriverWait

driver = webdriver.Chrome()
driver.maximize_window()

REGISTER_URL = "http://127.0.0.1:8000/register"
SUCCESS_URL = "http://127.0.0.1:8000/"

# Identifiant unique de l'exécution : évite le conflit "email déjà existant"
# quand on relance le script (sauf pour les emails très courts des valeurs limites).
RUN = int(time.time())


# -----------------------------
def soumettre(bouton):
    """Clique sur le bouton puis attend que la nouvelle page soit chargée.
    Si le navigateur bloque l'envoi (validation HTML5, ex. type="email"),
    la page ne change pas : on continue après le délai d'attente."""
    ancienne_page = driver.find_element(By.TAG_NAME, "html")
    bouton.click()
    try:
        WebDriverWait(driver, 5).until(EC.staleness_of(ancienne_page))
        WebDriverWait(driver, 5).until(
            lambda d: d.execute_script("return document.readyState") == "complete"
        )
    except TimeoutException:
        pass


def inscription(name, email, password, password_confirmation):
    driver.get(REGISTER_URL)

    driver.find_element(By.NAME, "name").clear()
    driver.find_element(By.NAME, "name").send_keys(name)

    driver.find_element(By.NAME, "email").clear()
    driver.find_element(By.NAME, "email").send_keys(email)

    driver.find_element(By.NAME, "password").clear()
    driver.find_element(By.NAME, "password").send_keys(password)

    driver.find_element(By.NAME, "password_confirmation").clear()
    driver.find_element(By.NAME, "password_confirmation").send_keys(password_confirmation)

    soumettre(driver.find_element(By.XPATH, "//button[text()='Sign Up']"))


def deconnecter():
    # Après une inscription réussie l'utilisateur est connecté :
    # on supprime les cookies pour revenir à un visiteur non connecté.
    driver.delete_all_cookies()


# -----------------------------
# VALEURS LIMITES
def valeur_attendue(field, val):
    if field == "name":
        return 1 <= val <= 255
    if field == "email":
        return 6 <= val <= 255
    if field == "password":
        return 6 <= val <= 255


def test_valeur_limite(field, values):
    for val in values:
        # Valeurs valides par défaut : seul le champ testé varie
        name = "Valid Name"
        email = f"user_{RUN}_{field}_{val}@test.com"
        password = "Password123"

        if field == "name":
            name = "A" * val
        elif field == "email":
            email = ("e" * (val - 5)) + "@t.fr"          # longueur totale = val
        elif field == "password":
            # longueur = val, avec une majuscule et un chiffre :
            # seule la longueur est testée, pas les autres règles du mot de passe
            password = ("P1" + "a" * (val - 2)) if val >= 2 else "P" * val

        print(f"Test {field} = {val}")

        inscription(name, email, password, password)

        observe = driver.current_url == SUCCESS_URL
        attendu = valeur_attendue(field, val)
        erreur_technique = "QueryException" in driver.page_source or "Data too long" in driver.page_source

        if observe == attendu and not erreur_technique:
            print("PASS")
        else:
            print("FAIL")
        print("-" * 40)

        deconnecter()


name_limits = [0, 1, 2, 254, 255, 256]
email_limits = [5, 6, 7, 254, 255, 256]
password_limits = [5, 6, 7, 254, 255, 256]

print("=== VALEURS LIMITES : NAME ===")
test_valeur_limite("name", name_limits)

print("=== VALEURS LIMITES : EMAIL ===")
test_valeur_limite("email", email_limits)

print("=== VALEURS LIMITES : PASSWORD ===")
test_valeur_limite("password", password_limits)


# -----------------------------
# TESTS – CLASSES VALIDES
EMAIL_CV1 = f"chaima_{RUN}@test.com"

print("CV1: Tous les champs valides")
inscription("Chaima Maatar", EMAIL_CV1, "Password123", "Password123")
if driver.current_url == SUCCESS_URL:
    print("[PASS] CV1 – Inscription réussie avec données valides")
else:
    print("[FAIL] CV1 – Inscription échouée (ERREUR)")
deconnecter()

# -----------------------------
# TESTS – CLASSES INVALIDES
print("CI1: Email déjà existant")
inscription("Chaima Maatar", EMAIL_CV1, "Password123", "Password123")
if driver.current_url == REGISTER_URL:
    print("[PASS] CI1 – Email déjà existant → refusé correctement")
else:
    print("[FAIL] CI1 – Email déjà existant → accepté (ERREUR)")
deconnecter()

print("CI2: Email invalide")
inscription("Test User", "email_invalide", "Password123", "Password123")
if driver.current_url == REGISTER_URL:
    print("[PASS] CI2 – Email invalide → refusé correctement")
else:
    print("[FAIL] CI2 – Email invalide → accepté (ERREUR)")
deconnecter()

print("CI3: Mot de passe sans majuscule")
inscription("Test User", f"noupper_{RUN}@test.com", "password123", "password123")
if driver.current_url == REGISTER_URL:
    print("[PASS] CI3 – Mot de passe sans majuscule → refusé correctement")
else:
    print("[FAIL] CI3 – Mot de passe sans majuscule → accepté (ERREUR)")
deconnecter()

print("CI4: Mot de passe sans chiffre")
inscription("Test User", f"nodigit_{RUN}@test.com", "Password", "Password")
if driver.current_url == REGISTER_URL:
    print("[PASS] CI4 – Mot de passe sans chiffre → refusé correctement")
else:
    print("[FAIL] CI4 – Mot de passe sans chiffre → accepté (ERREUR)")
deconnecter()

print("CI5: Confirmation mot de passe différente")
inscription("Test User", f"diffpass_{RUN}@test.com", "Password123", "Password321")
if driver.current_url == REGISTER_URL:
    print("[PASS] CI5 – Confirmation différente → refusée correctement")
else:
    print("[FAIL] CI5 – Confirmation différente → acceptée (ERREUR)")
deconnecter()

print("CI6: Champs requis manquants")
inscription("", "", "", "")
if driver.current_url == REGISTER_URL:
    print("[PASS] CI6 – Champs requis vides → refusé correctement")
else:
    print("[FAIL] CI6 – Champs requis vides → accepté (ERREUR)")
deconnecter()

# -----------------------------
# FERMETURE DU DRIVER
driver.quit()
