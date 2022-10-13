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
    public class CCertificadoCts
    {
        public List<ECertificadoCts> Listar_CertificadoCts(SqlConnection con, Int32 post, String dni, String periodo)
        {
            List<ECertificadoCts> lECertificadoCts = null;
            SqlCommand cmd = new SqlCommand("CERTIFICADO_CTS", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@post", SqlDbType.Int).Value = post;
            cmd.Parameters.AddWithValue("@dni", SqlDbType.VarChar).Value = dni;
            cmd.Parameters.AddWithValue("@periodo", SqlDbType.VarChar).Value = periodo;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lECertificadoCts = new List<ECertificadoCts>();

                ECertificadoCts obECertificadoCts = null;
                while (drd.Read())
                {
                    obECertificadoCts = new ECertificadoCts();
                    obECertificadoCts.RUC = drd["RUC"].ToString();
                    obECertificadoCts.RAZON = drd["RAZON"].ToString();
                    obECertificadoCts.DIRECCION = drd["DIRECCION"].ToString();
                    obECertificadoCts.PERID = drd["PERID"].ToString();
                    obECertificadoCts.NOMBRES = drd["NOMBRES"].ToString();
                    obECertificadoCts.FINGRESO = drd["FINGRESO"].ToString();
                    obECertificadoCts.FCESE = drd["FCESE"].ToString();
                    obECertificadoCts.ANHIO = drd["ANHIO"].ToString();
                    obECertificadoCts.PERIODO = drd["PERIODO"].ToString();
                    obECertificadoCts.REPRESENTANTE = drd["REPRESENTANTE"].ToString();
                    obECertificadoCts.ARTICULO = drd["ARTICULO"].ToString();
                    obECertificadoCts.LEY = drd["LEY"].ToString();
                    obECertificadoCts.DECRETO = drd["DECRETO"].ToString();
                    obECertificadoCts.FECHAPAGO = drd["FECHAPAGO"].ToString();
                    obECertificadoCts.NROCUENTA = drd["NROCUENTA"].ToString();
                    obECertificadoCts.ENTIDADBANCARIA = drd["ENTIDADBANCARIA"].ToString();
                    obECertificadoCts.MONEDA = drd["MONEDA"].ToString();
                    obECertificadoCts.TIPOCAMBIO = drd["TIPOCAMBIO"].ToString();
                    obECertificadoCts.FECHAINICIO = drd["FECHAINICIO"].ToString();
                    obECertificadoCts.FECHAFIN = drd["FECHAFIN"].ToString();
                    obECertificadoCts.SUELDOBASICO = drd["SUELDOBASICO"].ToString();
                    obECertificadoCts.ASIGNACIONFAMILIAR = drd["ASIGNACIONFAMILIAR"].ToString();
                    obECertificadoCts.ALIMENTACION = drd["ALIMENTACION"].ToString();
                    obECertificadoCts.COMISION = drd["COMISION"].ToString();
                    obECertificadoCts.HORASEXTRAS = drd["HORASEXTRAS"].ToString();
                    obECertificadoCts.SEXTOGRATIFICACION = drd["SEXTOGRATIFICACION"].ToString();
                    obECertificadoCts.MESESCOMPUTABLES = drd["MESESCOMPUTABLES"].ToString();
                    obECertificadoCts.DIASCOMPUTABLES = drd["DIASCOMPUTABLES"].ToString();
                    obECertificadoCts.RETENCIONJUD = drd["RETENCIONJUD"].ToString();
                    obECertificadoCts.CTSMESES = drd["CTSMESES"].ToString();
                    obECertificadoCts.CTSDIAS = drd["CTSDIAS"].ToString();
                    obECertificadoCts.CTSTOTAL = drd["CTSTOTAL"].ToString();
                    lECertificadoCts.Add(obECertificadoCts);
                }
                drd.Close();
            }

            return (lECertificadoCts);
        }
    }
}