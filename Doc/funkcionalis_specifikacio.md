# Funkcionális specifikáció

## 1. Jelenlegi helyzet
(lásd: követelményspecifikáció)

## 2. Vágyálom rendszer leírása
(lásd: követelményspecifikáció)

## 3. Jogszabályok és ajánlások
(lásd: követelményspecifikáció)

## 4. Jelenlegi üzleti folyamatok modellje
(lásd: követelményspecifikáció)

## 5. Az igényelt üzleti folyamat modellje
(lásd: követelményspecifikáció)

## 6. Követelménylista
(lásd: követelményspecifikáció)

## 7. Használati esetek
A rendszer használói a következők:

- **Adminisztrátor**:
  - Termékek felvétele, módosítása és törlése.
  - Rendelések kezelése (pl. állapot frissítése).
  

- **Vásárló**:
  - Termékkatalógus böngészése.
  - Termékek kosárba helyezése és rendelés leadása.
  

### A rendszer funkcióinak listája
1. **Adminisztrátorok**:
   - Termékek kezelése:
     - Terméknév, ár, leírás, kép feltöltése.
   - Rendelések kezelése:
     - Állapot frissítése (feldolgozás alatt, kiszállítva, teljesítve).

2. **Vásárlók**:
   - Keresés a termékkatalógusban.
   - Rendelés leadása és nyomon követése.



## 8. Képernyőtervek
- **Kezdőlap**: Az áruház bemutatása, termékek listázása.
- **Belépés**: Felhasználónév és jelszó megadása.
- **Kosár**: A kiválasztott termékek megjelenítése.
- **Rendelések**: Korábbi rendelt és aktuális megrendelések nyomon követése.


## 9. Forgatókönyvek
1. **Kezdőlap megtekintése**:
   - A felhasználó belép a kezdőlapra, és böngészhet a termékek között, amik lista szerűen jelennek meg.

2. **Kosár módosítása**:
   - A felhasználó termékeket adhat hozzá vagy törölhet a kosarából.

3. **Rendelés leadása**:
   - A felhasználó megadja a szállítási címet, majd kifizeti a rendelést.

4. **Adminisztráció**:
   - Az adminisztrátor új termékeket adhat hozzá az adatbázishoz, vagy törölhet meglévő elemeket és módosíthatja azokat.


## 10. Funkció–követelmény megfeleltetés
| ID       | Verzió        |Név    | Kifjetés |
|----------|:-------------:|------:|---------:|
| K01 | V1.0 | Reszponzív megjelenés | Jó megjeleníthető legyen több képernyő felbontásban
| K02 | V1.0 | Termékek adminisztrációja | A felhasználó feltudja venni a termékeket
| K03 | V1.0 | Egyszerű UI | Minimális interakcióval is eltudjon jutni a fizetésig
| K04 | V1.0 | Checkout és fizetési módok | 