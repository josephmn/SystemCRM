using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.Collections.Specialized;
using System.Linq;
using System.Web;
using System.Data;
using System.Data.SqlClient;
using WSRecursos.Entity;

namespace WSRecursos.Controller
{
    public class CBoletacabecera
    {
        public List<EBoletacabecera> Listar_Boletacabecera(SqlConnection con, String nroboleta)
        {
            List<EBoletacabecera> lEBoletacabecera = null;
            SqlCommand cmd = new SqlCommand("ASP_BOLETA_CEBECERA", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@nroboleta", SqlDbType.VarChar).Value = nroboleta;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEBoletacabecera = new List<EBoletacabecera>();

                EBoletacabecera obEBoletacabecera = null;
                while (drd.Read())
                {
                    obEBoletacabecera = new EBoletacabecera();
                    obEBoletacabecera.NBRBOLETA = drd["NBRBOLETA"].ToString();
                    obEBoletacabecera.RUC = drd["RUC"].ToString();
                    obEBoletacabecera.RAZONSOCIAL = drd["RAZONSOCIAL"].ToString();
                    obEBoletacabecera.PERIODO = drd["PERIODO"].ToString();
                    obEBoletacabecera.perpost = drd["perpost"].ToString();
                    obEBoletacabecera.periodo2 = drd["periodo2"].ToString();
                    obEBoletacabecera.DNI = drd["DNI"].ToString();
                    obEBoletacabecera.PERNOMBRE = drd["PERNOMBRE"].ToString();
                    obEBoletacabecera.PERPATERNO = drd["PERPATERNO"].ToString();
                    obEBoletacabecera.PERMATERNO = drd["PERMATERNO"].ToString();
                    obEBoletacabecera.SEXO = drd["SEXO"].ToString();
                    obEBoletacabecera.TTRABAJADOR = drd["TTRABAJADOR"].ToString();
                    obEBoletacabecera.PAIS = drd["PAIS"].ToString();
                    obEBoletacabecera.AREA = drd["AREA"].ToString();
                    obEBoletacabecera.SUBAREA = drd["SUBAREA"].ToString();
                    obEBoletacabecera.CARGO = drd["CARGO"].ToString();
                    obEBoletacabecera.TDOCUMENTO = drd["TDOCUMENTO"].ToString();
                    obEBoletacabecera.FINGRESO = drd["FINGRESO"].ToString();
                    obEBoletacabecera.FNACIMIENTO = drd["FNACIMIENTO"].ToString();
                    obEBoletacabecera.REGIMEN = drd["REGIMEN"].ToString();
                    obEBoletacabecera.REMUNERACION = drd["REMUNERACION"].ToString();
                    obEBoletacabecera.BASICO = drd["BASICO"].ToString();
                    obEBoletacabecera.TIPO_PAGO = drd["TIPO_PAGO"].ToString();
                    obEBoletacabecera.INICIO_CONTRATO = drd["INICIO_CONTRATO"].ToString();
                    obEBoletacabecera.FIN_CONTRATO = drd["FIN_CONTRATO"].ToString();
                    obEBoletacabecera.AFPNOMBRE = drd["AFPNOMBRE"].ToString();
                    obEBoletacabecera.NUMAFP = drd["NUMAFP"].ToString();
                    obEBoletacabecera.BANCO = drd["BANCO"].ToString();
                    obEBoletacabecera.CTABANCARIA = drd["CTABANCARIA"].ToString();
                    obEBoletacabecera.DLABORADOS = drd["DLABORADOS"].ToString();
                    obEBoletacabecera.FALTAS = drd["FALTAS"].ToString();
                    obEBoletacabecera.VACACIONES = drd["VACACIONES"].ToString();
                    obEBoletacabecera.DLCGH = drd["DLCGH"].ToString();
                    obEBoletacabecera.DLSGH = drd["DLSGH"].ToString();
                    obEBoletacabecera.SUSPECGH = drd["SUSPECGH"].ToString();
                    obEBoletacabecera.SUSPESGH = drd["SUSPESGH"].ToString();
                    obEBoletacabecera.DPERMISO = drd["DPERMISO"].ToString();
                    obEBoletacabecera.DMEDICO = drd["DMEDICO"].ToString();
                    obEBoletacabecera.SUBMATERNO = drd["SUBMATERNO"].ToString();
                    obEBoletacabecera.SUBINCAPACIDAD = drd["SUBINCAPACIDAD"].ToString();
                    obEBoletacabecera.DOTROS = drd["DOTROS"].ToString();
                    obEBoletacabecera.HLABORADAS = drd["HLABORADAS"].ToString();
                    obEBoletacabecera.HSOBRETIEMPO = drd["HSOBRETIEMPO"].ToString();
                    obEBoletacabecera.INGRESOS = drd["INGRESOS"].ToString();
                    obEBoletacabecera.DESCUENTOS = drd["DESCUENTOS"].ToString();
                    obEBoletacabecera.APORTES = drd["APORTES"].ToString();
                    obEBoletacabecera.FCORTEINICIO = drd["FCORTEINICIO"].ToString();
                    obEBoletacabecera.FCORTEFIN = drd["FCORTEFIN"].ToString();
                    obEBoletacabecera.FIRMA = drd["FIRMA"].ToString();
                    lEBoletacabecera.Add(obEBoletacabecera);
                }
                drd.Close();
            }

            return (lEBoletacabecera);
        }
    }
}