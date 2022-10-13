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
    public class CCertificadoUtilidades
    {
        public List<ECertificadoUtilidades> Listar_CertificadoUtilidades(SqlConnection con, Int32 anhio, string dni)
        {
            List<ECertificadoUtilidades> lECertificadoUtilidades = null;
            SqlCommand cmd = new SqlCommand("CERTIFICADO_UTILIDADES", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@anhio", SqlDbType.Int).Value = anhio;
            cmd.Parameters.AddWithValue("@dni", SqlDbType.VarChar).Value = dni;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lECertificadoUtilidades = new List<ECertificadoUtilidades>();

                ECertificadoUtilidades obECertificadoUtilidades = null;
                while (drd.Read())
                {
                    obECertificadoUtilidades = new ECertificadoUtilidades();
                    obECertificadoUtilidades.RUC = drd["RUC"].ToString();
                    obECertificadoUtilidades.RAZON = drd["RAZON"].ToString();
                    obECertificadoUtilidades.DIRECCION = drd["DIRECCION"].ToString();
                    obECertificadoUtilidades.REPRESENTANTE = drd["REPRESENTANTE"].ToString();
                    obECertificadoUtilidades.DECRETO = drd["DECRETO"].ToString();
                    obECertificadoUtilidades.PERID = drd["PERID"].ToString();
                    obECertificadoUtilidades.NOMBRES = drd["NOMBRES"].ToString();
                    obECertificadoUtilidades.FINGRESO = drd["FINGRESO"].ToString();
                    obECertificadoUtilidades.FCESE = drd["FCESE"].ToString();
                    obECertificadoUtilidades.PERIODO = drd["PERIODO"].ToString();
                    obECertificadoUtilidades.ANHIO = drd["ANHIO"].ToString();
                    obECertificadoUtilidades.RENTAANUALEMP = drd["RENTAANUALEMP"].ToString();
                    obECertificadoUtilidades.PORCENTAJE = drd["PORCENTAJE"].ToString();
                    obECertificadoUtilidades.MONTODIS = drd["MONTODIS"].ToString();
                    obECertificadoUtilidades.DIASLABORADOS = drd["DIASLABORADOS"].ToString();
                    obECertificadoUtilidades.DIASLABORADOSEJERCICIO = drd["DIASLABORADOSEJERCICIO"].ToString();
                    obECertificadoUtilidades.PARTICIPACIONDIAS = drd["PARTICIPACIONDIAS"].ToString();
                    obECertificadoUtilidades.REMUNERACIONESTOTALES = drd["REMUNERACIONESTOTALES"].ToString();
                    obECertificadoUtilidades.REMUNERACIONCOMPUTABLE = drd["REMUNERACIONCOMPUTABLE"].ToString();
                    obECertificadoUtilidades.PARTICIPACIONREMUNERACION = drd["PARTICIPACIONREMUNERACION"].ToString();
                    obECertificadoUtilidades.REMANENTEUTILIDADES = drd["REMANENTEUTILIDADES"].ToString();
                    obECertificadoUtilidades.REMANENTETOPE = drd["REMANENTETOPE"].ToString();
                    obECertificadoUtilidades.REMANENTEFONDOEMPLEADO = drd["REMANENTEFONDOEMPLEADO"].ToString();
                    obECertificadoUtilidades.RENTAQTAUTILIDADES = drd["RENTAQTAUTILIDADES"].ToString();
                    obECertificadoUtilidades.RETENCIONJUDICIAL = drd["RETENCIONJUDICIAL"].ToString();
                    obECertificadoUtilidades.PRESTAMOS = drd["PRESTAMOS"].ToString();
                    obECertificadoUtilidades.REINTEGRO = drd["REINTEGRO"].ToString();
                    obECertificadoUtilidades.FECHAPAGO = drd["FECHAPAGO"].ToString();
                    obECertificadoUtilidades.NROCUENTA = drd["NROCUENTA"].ToString();
                    obECertificadoUtilidades.ENTIDADBANCARIA = drd["ENTIDADBANCARIA"].ToString();
                    obECertificadoUtilidades.MONEDA = drd["MONEDA"].ToString();
                    obECertificadoUtilidades.TIPOCAMBIO = drd["TIPOCAMBIO"].ToString();
                    lECertificadoUtilidades.Add(obECertificadoUtilidades);
                }
                drd.Close();
            }

            return (lECertificadoUtilidades);
        }
    }
}