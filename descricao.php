$filtrado = 
[
	{
		"data":"01\/01\/1995",
		"codigoOrgao":57202,
		"registro":
			{
				"codigoRubrica":"00001",
				"descricaoRubrica":"VENCIMENTO BASICO",
				"valorRubrica":"292,82"
			}
	},
	
	{
		"data":"01\/01\/1995",
		"codigoOrgao":57202,
		"registro":
			{
				"codigoRubrica":"00013",
				"descricaoRubrica":"ART.244,LEI 8112\/90 AT",
				"valorRubrica":"40,99"
			}
	},
	
	{
		"data":"01\/01\/1995",
		"codigoOrgao":57202,
		"registro":
			{
				"codigoRubrica":"00065",
				"descricaoRubrica":"GRAT.EXERC.DETER.ZONAS\/LOCAIS",
				"valorRubrica":"17,56"
			}
	},
	{
		"data":"01\/01\/1995",
		"codigoOrgao":57202,
		"registro":
			{
				"descricaoRubrica":"INDENIZACAO DE TRANSPORTE",
				"valorRubrica":"49,39"
			}
	},
	{
		"data":"01\/01\/1995",
		"codigoOrgao":57202,
		"registro":
			{
				"codigoRubrica":"00092",
				"descricaoRubrica":"SALARIO FAMILIA",
				"valorRubrica":"0,65"
			}
	},
	{
		"data":"01\/01\/1995",
		"codigoOrgao":57202,
		"registro":
			{
				"codigoRubrica":"00192",
				"descricaoRubrica":"GRAT.EST.FISC.ARREC.TRIB.FED\/A",
				"valorRubrica":"3.188,40"
			}
	},
	{
		"data":"01\/01\/1995",
		"codigoOrgao":57202,
		"registro":
			{
				"codigoRubrica":"00678",
				"descricaoRubrica":"VANTAGEM PES.ART 5 L 8852\/94 A",
				"valorRubrica":"656,56"
			}
	},
	{
		"data":"01\/01\/1995",
		"codigoOrgao":57202,
		"registro":
			{
				"codigoRubrica":"00700",
				"descricaoRubrica":"ASSISTENCIA PRE-ESCOLAR",
				"valorRubrica":"64,00"
			}
	}
]




$periodo =

{
	"01/01/1995",
	"01/02/1995",
	"01/03/1995",
	"01/04/1995",
	"01/05/1995",
	"01/06/1995",
	"01/07/1995",
	"01/08/1995",
	"01/09/1995",
	"01/10/1995",
	"01/11/1995",
	"01/12/1995",
	.
	.
	.

	"01/08/2001",
	"01/09/2001",
	"01/10/2001",
	"01/11/2001",
	"01/12/2001"
}




$ocorrencias=

{
	"00001":"VENCIMENTO BASICO",
	"00013":"ANU\u00caNIO-ART.244,LEI 8112\/90 AT",
	"00065":"GRAT.EXERC.DETER.ZONAS\/LOCAIS",
	"00073":"FERIAS - ANTECIPACAO",
	"00079":"INDENIZACAO DE TRANSPORTE",
	"00092":"SALARIO FAMILIA",
	"00130":"RENDIMENTO PASEP",
	"00136":"AUX\u00cdLIO-ALIMENTAC\u00c3O",
	"00192":"GRAT.EST.FISC.ARREC.TRIB.FED\/A",
	"00220":"FERIAS - ADICIONAL 1\/3",
	"00330":"V.P.TRANSITORIA ART.2 MP1573-7",
	"00678":"VANTAGEM PES.ART 5 L 8852\/94 A",
	"00700":"ASSISTENCIA PRE-ESCOLAR",
	"00826":"CPMF - LEI 9.311\/96 - ATIVOS",
	"00852":"VANTAGEM PESS.ART.15 L.9527\/97",
	"00973":"GRAT.DESEMP.ATIV.TRIBUTARIA AT",
	"16135":"MS 9939091-7 4VF\/DF PSS\/AD FER",
	"19196":"MS 4151\/DF 9538195-8 C3\u00aaS 3,17",
	"98012":"DEVOLUCAO PLANO SEG.SOC - CPMF",
	"98502":"DEVOLUCAO PSS - ATIVO",
	"99001":"IMPOSTO DE RENDA RETIDO FONTE"
}




$matrizCalculo = {

	"01\/01\/1995":[
		{"00001":"292,82"},
		{"00013":"40,99"},
		{"00065":"17,56"},
		{"00079":"49,39"},
		{"00092":"0,65"},
		{"00192":"3.188,40"},
		{"00678":"656,56"},
		{"00700":"64,00"},
		{"00700":"64,00"}
	],

	"01\/02\/1995":[
		{"00001":"357,44"},
		{"00013":"50,04"},
		{"00065":"21,44"},
		{"00092":"0,75"},
		{"00192":"4.194,00"},
		{"00700":"64,00"},
		{"00700":"64,00"}
	],
	.
	.
	.

	"01\/03\/1995":[
		{"00001":"357,44"},
		{"00013":"50,04"},
		{"00065":"21,44"},
		{"00079":"59,72"},
		{"00092":"0,75"},
		{"00192":"4.194,00"},
		{"00700":"64,00"},
		{"00700":"64,00"},
		{"99001":"106,73"}
	]
}







