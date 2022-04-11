// var arrEstados;
// var contEstado = 0;
// var contadorCidade = 0;

// // apagar tudo abaixo depoiis

// function listaCidades(){
// 	$.ajax({
// 		url: 'https://servicodados.ibge.gov.br/api/v1/localidades/estados',
// 		method: 'get',
// 		dataType: 'json',
// 		success: function(estado){
// 			arrEstados = estado;
// 			insere();
// 		}
// 	});
// }

// function insere(){
// 	if(contEstado < arrEstados.length){
// 		estado(arrEstados[contEstado].id,arrEstados[contEstado].sigla)
// 		contEstado++;
// 	}else{
// 		console.log('chegou ao limite');
// 	}
// }

// function estado(idEstado,sigla){
// 	var url1='https://servicodados.ibge.gov.br/api/v1/localidades/estados/';
// 	url1 += idEstado +'/municipios';
// 	$.ajax({
// 		url: url1,
// 		method: 'get',
// 		dataType: 'json',
// 		success: function(cidade){
// 			var contCidade = 0;

// 			function insereCidade(){
// 				setTimeout(function(){
// 					if(contCidade < cidade.length){
// 						var cidadeNome = cidade[contCidade].nome;

// 						if(contCidade < cidade.length){

// 							$.ajax({
// 								url: PAINEL+'estados/novo',
// 								method: 'post',
// 								dataType: 'html',
// 								data:{'cidade':cidadeNome,'estado':sigla},
// 								success: function(res){
// 									contadorCidade++;
// 									console.log('estado:'+contEstado+' cidade:'+contadorCidade ' '+ res);
// 								}
// 							});
// 							contCidade++;
// 							insereCidade();
// 						}else{
// 							console.log('nao há mais cidades');
// 						}
// 					}else{
// 						console.log('todas as cidades do estado foram cadastradas');
// 						insere();
// 					}
// 				},500);
// 			}
// 			insereCidade();
// 		}
// 	});
// }