/**
 * Connection ajax
 * @returns {ActiveXObject|XMLHttpRequest|Boolean}
 * @author LETICEE Lory <loryleticee@gmail.com>
 */
function getXhr(){
                                var xhr = null; 
				if(window.XMLHttpRequest) 
				   xhr = new XMLHttpRequest(); 
				else if(window.ActiveXObject){ 
				   try {
			                xhr = new ActiveXObject("Msxml2.XMLHTTP");
			            } catch (e) {
			                xhr = new ActiveXObject("Microsoft.XMLHTTP");
			            }
				}
				else { 
				   alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest..."); 
				   xhr = false; 
				} 
                                return xhr;
			}

						function alterMat(i){
				var xhr = getXhr();
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						leselect = xhr.responseText;
						document.getElementById('resultat').innerHTML = leselect;
					}
				}
				id = document.getElementById('id'+i).value;
				nom = document.getElementById('nomMat'+i).value;
				num = document.getElementById('numMat'+i).value;
				xhr.open("POST","vues/ajax/v_modifierMat.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				
				xhr.send("id="+id+"."+nom+"."+num);
                                           
			}

			function delMat(i){
				var xhr = getXhr();
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						leselect = xhr.responseText;
						document.getElementById('resultat').innerHTML = leselect;
					}
				}
				if (confirm("Vous allez bientôt supprimer un engin...")) { // Clic sur OK supprimerSal(sal);}
					id = document.getElementById('id'+i).value;
					num = document.getElementById('numMat'+i).value;
					xhr.open("POST","vues/ajax/v_deleteMat.php",true);
					xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
					id = document.getElementById('id'+i).value;
					xhr.send("id="+id+'.'+num);
				}
            }
 
			/**
			* Méthode qui sera appelée sur le click du bouton
**/
/**Recupere l'identifiant du visiteur choisit et appele le fichier v_ajaxLesMoisVisiteur.php 
 * @returns {undefined}
 * 
 */
						function voirWeek(){
				var xhr = getXhr();
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						leselect = xhr.responseText;
						document.getElementById('lstWeek').innerHTML = leselect;
					}
				}
				xhr.open("POST","vues/ajax/v_ChantierByWeek.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				sel = document.getElementById('listChantier');
				idChant = sel.options[sel.selectedIndex].value;
				xhr.send("idChant="+idChant);          
			}

			function voirPointageWeek(){
				var xhr = getXhr();
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						leselect = xhr.responseText;
						document.getElementById('lstPointage').innerHTML = leselect;
					}
				}
				xhr.open("POST","vues/ajax/v_ficheByWeek.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				sel = document.getElementById('listWeek');
				idWeek = sel.options[sel.selectedIndex].value;
				xhr.send("idWeek="+idWeek);          
			}
			function voirPointageDay(){
				var xhr = getXhr();
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						leselect = xhr.responseText;
						document.getElementById('lstPointage').innerHTML = leselect;
					}
				}
				xhr.open("POST","vues/ajax/v_ficheByWeek.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				sel = document.getElementById('listjour');
				idDay = sel.options[sel.selectedIndex].value;
				xhr.send("idDay="+idDay);          
			}
			function voirPointageDayBis(chef){
				var xhr = getXhr();
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						leselect = xhr.responseText;
						document.getElementById('lstPointage').innerHTML = leselect;
					}
				}
				xhr.open("POST","vues/ajax/v_ficheByWeek.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				xhr.send("chef="+chef);          
			}
			function voirPointageDayBisBis(numero){
				var xhr = getXhr();
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						leselect = xhr.responseText;
						document.getElementById('lstPointage').innerHTML = leselect;
					}
				}
				xhr.open("POST","vues/ajax/v_ficheByWeek.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				xhr.send("numb="+numero);          
			}
            function voirFrais(){
				var xhr = getXhr();
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						leselec = xhr.responseText;
						document.getElementById('f').innerHTML = leselec;
					}
				}
				xhr.open("POST","vues/v_fraisAuForfaits.php",true);

				// ne pas oublier ça pour le post
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				sel = document.getElementById('lstMois');
				mois = sel.options[sel.selectedIndex].value;
				xhr.send("mois="+mois);   
			}
			function alterSalarie(i){
				var xhr = getXhr();
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						leselect = xhr.responseText;
						document.getElementById('resultat').innerHTML = leselect;
					}
				}
				id = document.getElementById('id'+i).value;
				nom = document.getElementById('nom'+i).value;
				prenom = document.getElementById('prenom'+i).value;
				xhr.open("POST","vues/ajax/v_modifierSal.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

				xhr.send("id="+id+"."+nom+"."+prenom);
                                           
			}

			function delSal(i){
				var xhr = getXhr();
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						leselect = xhr.responseText;
						document.getElementById('resultat').innerHTML = leselect;
					}
				}
				if (confirm("Vous allez bientôt supprimer un salarié...")) { // Clic sur OK supprimerSal(sal);}
									
					xhr.open("POST","vues/ajax/v_deleteSal.php",true);
					xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
					id = document.getElementById('id'+i).value;
					xhr.send("id="+id);
				}
            }
                           			function alterTheme(i){
				var xhr = getXhr();
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						leselect = xhr.responseText;
						document.getElementById('resultat').innerHTML = leselect;
					}
				}
				id = document.getElementById('id'+i).value;
				nom = document.getElementById('nomTheme'+i).value;
				xhr.open("POST","vues/ajax/v_modifierTheme.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

				xhr.send("id="+id+"."+nom);
                                           
			}

			function delTheme(i){
				var xhr = getXhr();
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						leselect = xhr.responseText;
						document.getElementById('resultat').innerHTML = leselect;
					}
				}
				if (confirm("Vous allez bientôt supprimer un theme...")) { // Clic sur OK supprimerSal(sal);}
									
					xhr.open("POST","vues/ajax/v_deleteTheme.php",true);
					xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
					id = document.getElementById('id'+i).value;
					xhr.send("id="+id);
				}
            }
			function alterDoc(i){
				var xhr = getXhr();
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						leselect = xhr.responseText;
						document.getElementById('resultat').innerHTML = leselect;
					}
				}
				id = document.getElementById('id'+i).value;
				nom = document.getElementById('nomDoc'+i).value;
				xhr.open("POST","vues/ajax/v_modifierDoc.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

				xhr.send("id="+id+"."+nom);
                                           
			}
			function delDoc(i){
				var xhr = getXhr();
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						leselect = xhr.responseText;
						document.getElementById('resultat').innerHTML = leselect;
					}
				}
				if (confirm("Vous allez bientôt supprimer un document...")) { // Clic sur OK supprimerSal(sal);}
									
					xhr.open("POST","vues/ajax/v_deleteDoc.php",true);
					xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
					id = document.getElementById('id'+i).value;
					xhr.send("id="+id);
				}
            }
            function alterGroup(i){
				var xhr = getXhr();
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						leselect = xhr.responseText;
						document.getElementById('resultat').innerHTML = leselect;
					}
				}
				id = document.getElementById('id'+i).value;
				nom = document.getElementById('nomGroup'+i).value;
				xhr.open("POST","vues/ajax/v_modifierGroup.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

				xhr.send("id="+id+"."+nom);
                                           
			}
			function delGroup(i){
				var xhr = getXhr();
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						leselect = xhr.responseText;
						document.getElementById('resultat').innerHTML = leselect;
					}
				}
				if (confirm("Vous allez bientôt supprimer une entreprise...")) { // Clic sur OK supprimerSal(sal);}		
					xhr.open("POST","vues/ajax/v_deleteGroup.php",true);
					xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
					id = document.getElementById('id'+i).value;
					xhr.send("id="+id);
				}
            }
            function alterChant(i){
				var xhr = getXhr();
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						leselect = xhr.responseText;
						document.getElementById('resultat').innerHTML = leselect;
					}
				}
				xhr.open("POST","vues/ajax/v_modifChantier.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				id = document.getElementById('id'+i).value;
				nom = document.getElementById('nomChant'+i).value;
				num = document.getElementById('numChant'+i).value;
				xhr.send("id="+id+'.'+nom+'.'+num);
                                           
			}

			function delChant(i){
				var xhr = getXhr();
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						leselect = xhr.responseText;
						document.getElementById('resultat').innerHTML = leselect;
					}
				}
				if (confirm("Vous allez bientôt supprimer un chantier...")) { // Clic sur OK supprimerSal(sal);}
					xhr.open("POST","vues/ajax/v_deleteChantier.php",true);
					xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
					id = document.getElementById('id'+i).value;
					xhr.send("id="+id);
				}
            }

       		function comfirmer(sal) {
       			if (confirm("Voulez-vous vraiment supprimer "+sal+" ?")) { // Clic sur OK
          			supprimer(sal);
      			 }
      		}
      		function alterConsigne(i){
				var xhr = getXhr();
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						leselect = xhr.responseText;
						document.getElementById('resConsigne').innerHTML = leselect;
					}
				}
				voie = 	document.getElementById('voieConsigne'+i).value;
				date = 	document.getElementById('jourConsigne'+i).value;				
				aitcDebut = document.getElementById('aitc1'+i).value;	
				aitcFin = document.getElementById('aitc2'+i).value;
				cCD = document.getElementById('cCD'+i).value;
				cCF = document.getElementById('ccF'+i).value;
				travauxD = 	document.getElementById('travauxD'+i).value;	
				travauxF = 	document.getElementById('travauxF'+i).value;
				if (confirm("Cette modification est la bonne pour Voie "+voie+" ?\n"+aitcDebut+"\n"+aitcFin+"\n"+cCD+"\n"+cCF+"\n"+travauxD+"\n"+travauxF)) {	
					xhr.open("POST","vues/ajax/v_modifierVoie.php",true);
					xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
					xhr.send("id="+voie+"."+date+'.'+aitcDebut+"."+aitcFin+"."+cCD+"."+cCF+"."+travauxD+"."+travauxF);
				}
                                           
			}

			function delConsigne(i){
				var xhr = getXhr();
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						leselect = xhr.responseText;
						document.getElementById('resConsigne').innerHTML = leselect;
					}
				}
				if (confirm("Vous allez bientôt supprimer un salarié...")) { // Clic sur OK supprimerSal(sal);}
									
					xhr.open("POST","vues/ajax/v_deleteSal.php",true);
					xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
					id = document.getElementById('voieConsigne'+i).value;
					xhr.send("id="+id);
				}
            }

      		function VerifForm(formulaire){
				adresse = formulaire.email.value;
				var place = adresse.indexOf("@",1);
				var point = adresse.indexOf(".",place+1);
				if ((place > -1)&&(adresse.length >2)&&(point > 1)){
					formulaire.submit();
					return(true);
				}
				else{
					alert('Entrez une adresse e-mail valide');
					return(false);
				}
			}
   
  			 function validation(f) {
 				 if (f.mdp.value == '' || f.mdp1.value == '') {
    				alert('Tous les champs ne sont pas remplis');
    				f.mdp.focus();
    				return false;
  				 }
  				else if (f.mdp.value != f.mdp1.value) {
    				alert('Ce ne sont pas les mêmes mots de passe!');
    				f.mdp.focus();
    				return false;
    			}
  				else if (f.mdp.value == f.mdp1.value) {
    				return true;
    			}
  				else {
    				f.mdp.focus();
    				return false;
    			}
  			}
//Pointage des salariées
  			function pointerOuvrier(sal){
				var xhr = getXhr();
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						leselect = xhr.responseText;
						document.getElementById('resultat').innerHTML = leselect;
					}
				}
				xhr.open("POST","vues/v_pointer.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				id = sal;
				xhr.send("id="+id);
            }

//Dépointage des salariées

            function depointerOuvrier(sal){
				var xhr = getXhr();
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						leselect = xhr.responseText;
						document.getElementById('resultat').innerHTML = leselect;
					}
				}
				xhr.open("POST","vues/v_depointer.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				id = sal;
				xhr.send("id="+id);
            }

//pointage des engins

            function pointerEngin(engin){
				var xhr = getXhr();
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						leselect = xhr.responseText;
						document.getElementById('resultat').innerHTML = leselect;
					}
				}
				xhr.open("POST","vues/v_pointerEngin.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				id = engin;
				xhr.send("id="+id);
           }

//Depointagedes engins

            function depointerEngin(engin){
				var xhr = getXhr();
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						leselect = xhr.responseText;
						document.getElementById('resultat').innerHTML = leselect;
					}
				}
				xhr.open("POST","vues/v_depointerEngin.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				id = engin;
				xhr.send("id="+id);
            }
            function commenter(){
				var xhr = getXhr();
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						leselect = xhr.responseText;
						document.getElementById('resultat').innerHTML = leselect;
					}
				}
				xhr.open("POST","vues/v_commenter.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				com = document.getElementById('comment').value;
				xhr.send("com="+com);
            }

       		function comfirmerOut() {
       			var xhr = getXhr();
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						leselect = xhr.responseText;
						document.getElementById('contenu').innerHTML = leselect;
					}
				}
       			if (confirm("Voulez-vous vraiment quitter ?")) { 
      				deconnection();
      			 }
      		}
      		function deconnection(){
				var xhr = getXhr();
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						leselect = xhr.responseText;
						document.getElementById('page').innerHTML = leselect;
					}
				}
				xhr.open("POST","vues/ajax/v_deconnexion.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				xhr.send();
            }
			function searchOuvrier(debut){
				var xhr = getXhr();
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						leselect = xhr.responseText;
						document.getElementById('res').innerHTML = leselect;
					}
				}
				xhr.open("POST","vues/ajax/v_search_ouvrier.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				letta = debut;
				xhr.send("letta="+letta);
            }
            	function searchOuvrierAccueil(debut){
				var xhr = getXhr();
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						leselect = xhr.responseText;
						document.getElementById('resAccueil').innerHTML = leselect;
					}
				}
				xhr.open("POST","vues/v_search_ouvrierAcceuil.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				letta = debut;
				xhr.send("letta="+letta);
            }
            function dater(heure){
				var xhr = getXhr();
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						leselect = xhr.responseText;
						document.getElementById('dater').innerHTML = leselect;
					}
				}
				xhr.open("POST","vues/v_dater.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				hour = heure;
				xhr.send("jour="+hour);
            }
            function sendMail(m){
				var xhr = getXhr();
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						leselect = xhr.responseText;
						document.getElementById('resultatDeux').innerHTML = leselect;
					}
				}
				xhr.open("POST","vues/ajax/v_mailPanne.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				msg = m;
				xhr.send("msg="+msg);
            }
            function addNewTheme(m){
				var xhr = getXhr();
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						leselect = xhr.responseText;
						document.getElementById('resultat').innerHTML = leselect;
					}
				}
				xhr.open("POST","vues/v_newTheme.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				theme = m;
				xhr.send("theme="+theme);
            }
            function addSalAccueil(idSal){
				var xhr = getXhr();
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						leselect = xhr.responseText;
						document.getElementById('resultat').innerHTML = leselect;
					}
				}
				xhr.open("POST","vues/v_addSalAcc.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				id = idSal;
				xhr.send("id="+id);
            }
            function  changeListSal(idChant){
				var xhr = getXhr();
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						leselect = xhr.responseText;
						document.getElementById('myAccueil').innerHTML = leselect;
					}
				}
				xhr.open("POST","vues/v_accuelListSal.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				id = idChant;
				xhr.send("id="+id);
            }
                        function getIdFiche(){
				var xhr = getXhr();
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						leselect = xhr.responseText;
						document.getElementById('fiche').innerHTML = leselect;
					}
				}
				idChant=document.getElementById('listChantier').value;
				xhr.open("POST","vues/v_getIdFiche.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				id = idChant;
				xhr.send("id="+id);
            }
           	function alterPointage(i){
				var xhr = getXhr();
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						leselect = xhr.responseText;
						document.getElementById('resultat').innerHTML = leselect;
					}
				}
				nom = document.getElementById('nom'+i).value;
				debutD = document.getElementById('debutOne'+i).value;
				finD = document.getElementById('finOne'+i).value;
				debutF = document.getElementById('debut'+i).value;
				finF = document.getElementById('fin'+i).value;
				xhr.open("POST","vues/ajax/v_modifierPointage.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				xhr.send("pointage="+nom+"."+debutD+"."+finD+"."+debutF+"."+finF);                            
			}
			function delPointage(i){
				var xhr = getXhr();
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						leselect = xhr.responseText;
						document.getElementById('resultat').innerHTML = leselect;
					}
				}
				nom = document.getElementById('nom'+i).value;
				chantier = document.getElementById('chantier'+i).value;
				date = document.getElementById('debutOne'+i).value;
				if (confirm("Voulez-vous vraiment supprimer "+nom+" ?")) { 
					xhr.open("POST","vues/ajax/v_delPointage.php",true);
					xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
					xhr.send("nom="+nom+"."+chantier+"."+date);  
				}                          
			}
			function alterPointageEngin(i){
				var xhr = getXhr();
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						leselect = xhr.responseText;
						document.getElementById('resPointageEngin').innerHTML = leselect;
					}
				}
				nom = document.getElementById('nomEngin'+i).value;
				num = document.getElementById('numEngin'+i).value;
				jour = document.getElementById('jourEngin'+i).value;
				indice = document.getElementById('indice'+i).value;
				if (indice.length>2) {
					a=indice.substring(0,1);
					indice=a;
				}
				xhr.open("POST","vues/ajax/v_modifierPointageEngin.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				xhr.send("pointage="+nom+"."+num+"."+jour+"."+indice);                            
			}
			function delPointageEngin(i){
				var xhr = getXhr();
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						leselect = xhr.responseText;
						document.getElementById('resPointageEngin').innerHTML = leselect;
					}
				}
				nom = document.getElementById('nomEngin'+i).value;
				num = document.getElementById('numEngin'+i).value;
				numChantier = document.getElementById('numChantierEngin'+i).value;
				jour = document.getElementById('jourEngin'+i).value;
				if (confirm("Voulez-vous vraiment supprimer "+nom+" ?")) { // Clic sur OK
          			xhr.open("POST","vues/ajax/v_delPointageEngin.php",true);
					xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
					xhr.send("nom="+nom+"."+num+"."+jour+"."+numChantier);   
      			}       
			}
			function voirCategorie(){
				var xhr = getXhr();
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						leselect = xhr.responseText;
						document.getElementById('resMateriel').innerHTML = leselect;
					}
				}
				id = document.getElementById('listCategorie').value;
				if(id==0){
					xhr.open("POST","vues/ajax/v_search_engin.php",true);
				}
				else{
					if(id==3){
						xhr.open("POST","vues/ajax/v_add_engin_group.php",true);
					}else{
						xhr.open("POST","vues/ajax/v_add_engin.php",true);
					}
					
				}
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				xhr.send("id="+id);                            
			}

			function searchEngin(debut){
				var xhr = getXhr();
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						leselect = xhr.responseText;
						document.getElementById('resEngin').innerHTML = leselect;
					}
				}
				xhr.open("POST","vues/ajax/v_completion_engin.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				letta = debut;
				xhr.send("letta="+letta);
            }
            function tAR(msg){
				var xhr = getXhr();
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						leselect = xhr.responseText;
						document.getElementById('resultatDeux').innerHTML = leselect;
					}
				}
				xhr.open("POST","vues/ajax/v_tAR.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				message = msg;
				xhr.send("message="+message);
            }
            function mAP(msg){
				var xhr = getXhr();
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						leselect = xhr.responseText;
						document.getElementById('resultatDeux').innerHTML = leselect;
					}
				}
				xhr.open("POST","vues/ajax/v_mAP.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				message = msg;
				xhr.send("message="+message);
            }
            function signerPointage(sign){
				var xhr = getXhr();
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						leselect = xhr.responseText;
						document.getElementById('resultat').innerHTML = leselect;
					}
				}
				xhr.open("POST","vues/ajax/v_validerPointage.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				signature = sign;
				xhr.send("signature="+signature);
            }
            function createMeteo(meteo){
				var xhr = getXhr();
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						leselect = xhr.responseText;
						document.getElementById('resultat').innerHTML = leselect;
					}
				}
				xhr.open("POST","vues/ajax/v_meteo.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				m = meteo;
				xhr.send("meteo="+m);
            }
            function saveMeteo(meteo){
				var xhr = getXhr();
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						leselect = xhr.responseText;
						document.getElementById('resultatUn').innerHTML = leselect;
					}
				}
				xhr.open("POST","vues/ajax/v_saveMeteo.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				m = meteo;
				xhr.send("meteo="+m);
            }
            function addConsigne(){
				var xhr = getXhr();
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						leselect = xhr.responseText;
						document.getElementById('resVoie').innerHTML = leselect;
					}
				}
				xhr.open("POST","vues/ajax/v_addVoie.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				xhr.send();
            }
            function addVoie(){
				var xhr = getXhr();
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						leselect = xhr.responseText;
						document.getElementById('resultatUn').innerHTML = leselect;
					}
				}
				numVoie = document.getElementById('nVoie').value;
				AITC0 = document.getElementById('hDebutAITC').value;
				AITC1 = document.getElementById('hFinAITC').value;
				cCatenaireD = document.getElementById('hDebutC').value;
				cCatenaireF = document.getElementById('hFinC').value;
				hD = document.getElementById('hDebutT').value;
				hF = document.getElementById('hFinT').value;
				if (numVoie =='' || AITC0  =='' || numVoie  =='n1:n2:n3...') {
					alert("Remplissez au moins les deux premiers champs");
				}
				else{
					xhr.open("POST","vues/ajax/v_saveVoie.php",true);
					xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
					xhr.send("voie="+numVoie+'.'+AITC0+'.'+AITC1+'.'+cCatenaireD+'.'+cCatenaireF+'.'+hD+'.'+hF);
				}
            }
            function showSearchOuvrier(){
				var xhr = getXhr();
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						leselect = xhr.responseText;
						document.getElementById('chantier').innerHTML = leselect;
					}
				}
				numChantier = document.getElementById('lieu').value;
				xhr.open("POST","vues/ajax/v_addSearchOuvrier.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				xhr.send("chantier="+numChantier);
            }
            function alterConsigne(i){
				var xhr = getXhr();
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						leselect = xhr.responseText;
						document.getElementById('resConsigne').innerHTML = leselect;
					}
				}
				nomVoie = document.getElementById('voieConsigne'+i).value;
				jour = document.getElementById('jourConsigne'+i).value;
				aitc1 = document.getElementById('aitc1'+i).value;
				aitc2= document.getElementById('aitc2'+i).value;
				cCD = document.getElementById('cCD'+i).value;
				cCF = document.getElementById('cCF'+i).value;
				debut = document.getElementById('travauxD'+i).value;
				fin = document.getElementById('travauxF'+i).value;
				xhr.open("POST","vues/ajax/v_modifierConsigne.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				xhr.send("nomVoie="+nomVoie+'.'+jour+'.'+aitc1+'.'+aitc2+'.'+cCD+'.'+cCF+'.'+debut+'.'+fin);
            }
             function delConsigne(i){
				var xhr = getXhr();
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						leselect = xhr.responseText;
						document.getElementById('resConsigne').innerHTML = leselect;
					}
				}
				nomVoie = document.getElementById('voieConsigne'+i).value;
				jour = document.getElementById('jourConsigne'+i).value;
				if (confirm("Voulez-vous vraiment supprimer "+nomVoie+" ?")) { 
					xhr.open("POST","vues/ajax/v_deleteConsigne.php",true);
					xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
					xhr.send("nomVoie="+nomVoie+'.'+jour);
				}
            }
            function sureName(v){
				var xhr = getXhr();
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						leselect = xhr.responseText;
						document.getElementById('resultat').innerHTML = leselect;
					}
				}
					xhr.open("POST","vues/ajax/v_changeUser.php",true);
					xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
					xhr.send("user="+v);				
            }
            function askNewGroup(msg){
				var xhr = getXhr();
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						leselect = xhr.responseText;
						document.getElementById('resultat').innerHTML = leselect;
					}
				}
					xhr.open("POST","vues/ajax/v_askAddGroup.php",true);
					xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
					xhr.send("user="+v);				
            }
            function delBani(v){
				var xhr = getXhr();
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						leselect = xhr.responseText;
						document.getElementById('resultat').innerHTML = leselect;
					}
				}
					adresse=v;
					alert(adresse);
					xhr.open("POST","vues/ajax/v_delBani.php",true);
					xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
					xhr.send("adresse="+adresse);				
            }
            function backPointage(){
				var xhr = getXhr();
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						leselect = xhr.responseText;
						document.getElementById('contenu').innerHTML = leselect;
					}
				}
					xhr.open("POST","vues/v_fichePointageYesterday.php",true);
					xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
					xhr.send();				
            }
            function pointageBack(v){
				var xhr = getXhr();
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						leselect = xhr.responseText;
						document.getElementById('resultat').innerHTML = leselect;
					}
				}
				tab=v.split('');
				if (tab[0]=='1') {
					nbr=tab[1];
					//pour chaque pointage
					for (var i = 0; i <nbr; i++) {
						nom = document.getElementById('nom'+i).value;
						chantier = document.getElementById('chantier'+i).value;
						debutOne = document.getElementById('debutOne'+i).value;
						finOne = document.getElementById('finOne'+i).value;
						debut = document.getElementById('debut'+i).value;
						fin = document.getElementById('fin'+i).value;
						xhr.open("POST","vues/ajax/v_pointerSalYesterday.php",true);
						xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
						xhr.send("id="+nom+'.'+chantier+'.'+debutOne+'.'+finOne+'.'+debut+'.'+fin);	
					};			
				}else{
					if (tab[0]=='2') {
						nbr=tab[1];
						//pour chaque pointage
						for (var i = nbr; i=1; i--) {
							nom = document.getElementById('nom'+i).value;
							chantier = document.getElementById('chantier'+i).value;
							debutOne = document.getElementById('debutOne'+i).value;
							finOne= document.getElementById('finOne'+i).value;
							debut = document.getElementById('debut'+i).value;
							fin = document.getElementById('fin'+i).value;
						}
					}
					xhr.open("POST","vues/v_fichePointageYesterday.php",true);
					xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
					xhr.send();	
				}			
            }
            function createSDate(date){
				var xhr = getXhr();
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						leselect = xhr.responseText;
						document.getElementById('resultat').innerHTML = leselect;
					}
				}
					xhr.open("POST","vues/ajax/v_createDate.php",true);
					xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
					xhr.send("date="+date);				
            }
            function addOdaSal(){
				var xhr = getXhr();
				xhr.onreadystatechange = function(){
					if(xhr.readyState == 4 && xhr.status == 200){
						leselect = xhr.responseText;
						document.getElementById('res').innerHTML = leselect;
					}
				}
					xhr.open("POST","vues/ajax/v_addOdaSal.php",true);
					xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
					xhr.send();				
            }
           
            