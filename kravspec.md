jj222kc_webbutveckling_med_php
==============================

webbutveckling med php

Projektkrav:

UC 1 Ladda upp bild
Förkrav: Användaren är inloggad.
1. Startar när en användare valt att ladda upp en bild.
2. Systemet ber användaren ange vilken bild som ska laddas upp.
3. Användaren väljer önskad bild.
4. Systemet validerar formatet på bilden och meddelar användaren om uppladdningen lyckas/misslyckas.

UC 2. Logga in
Förkrav: 
1. Startar när en användare vill logga in. 
2. Systemet ber användaren om användarnamn och lösenord.
3. Användar skriver in användarnamn och lösenord.
4. Systemet validerar användaren och meddelar att inloggning lyckades/misslyckades.

UC 3. Kommentera
Förkrav: Användaren är inloggad och det finns inlägg att kommentera.
1. Startar när en användaren väljer ett inlägg att kommentera.
2. Systemet presenterar ett kommentarsfält på sidan för användaren att fylla i. 
3. Användaren skriver en kommentar i fältet och skickar den. 
4. Systemet validerar kommentaren och presenterar sedan kommentaren på sidan.

UC 4. Redigera kommentar
Förkrav: Användaren är inloggad och det finns inlägg att kommentera.
1. Startar när en användaren väljer en kommentar att kommentera.
2. Systemet presenterar alla tillgängliga kommentar att redigera på sidan för användaren att ändra. 
3. Användaren skriver en kommentar i fältet och skickar den. 
4. Systemet validerar kommentaren och presenterar sedan kommentaren på sidan.

UC 5. Ta bort kommentar
Förkrav: Användaren är inloggad och det finns inlägg att ta bort.
1. Startar när en användaren väljer en kommentar att ta bort.
2. Systemet presenterar alla tillgängliga kommentar att redigera på sidan för användaren att ändra. 
3. Användaren skriver en kommentar i fältet och skickar den. 
4. Systemet validerar kommentaren och presenterar sedan kommentaren på sidan.

UC 6. Registrera användare
Förkrav: 
1. Startar när en användare vill registrera sig. 
2. Systemet ber användaren om användarnamn och lösenord.
3. Användar skriver in användarnamn och lösenord.
4. Systemet validerar användaren och lösenord och meddelar om registreringen lyckades/misslyckades.


Krav 2. Logga in Casual
Användaren väljer att han/hon vill logga in och får ett inloggningsformulär presenterat 
där användaren sedan fyller i sina användardata(användarnamn/lösenord). Systemet bearbetar informationen och talar
sedan om för användaren om det är giltliga data. Om valideringen misslyckas så presenteras ett 
felmeddelande som talar om vad som är fel.


Krav 3. Kommentera Brief
Användaren fyller i kommentarsfältet på ett inlägg för att sedan bli presenterat med den inlagda kommentaren.
