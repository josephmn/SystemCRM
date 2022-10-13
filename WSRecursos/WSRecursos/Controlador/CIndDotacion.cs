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
    public class CIndDotacion
    {
        public List<EIndDotacion> Listar_IndDotacion(SqlConnection con)
        {
            List<EIndDotacion> lEIndDotacion = null;
            SqlCommand cmd = new SqlCommand("ASP_INDDOTACION", con);
            cmd.CommandType = CommandType.StoredProcedure;
            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEIndDotacion = new List<EIndDotacion>();

                EIndDotacion obEIndDotacion = null;
                while (drd.Read())
                {
                    obEIndDotacion = new EIndDotacion();
                    obEIndDotacion.i_anhio = drd["i_anhio"].ToString();
                    obEIndDotacion.v_meses = drd["v_meses"].ToString();
                    obEIndDotacion.f_bruto = drd["f_bruto"].ToString();
                    obEIndDotacion.i_target = drd["i_target"].ToString();
                    obEIndDotacion.i_desviacion = drd["i_desviacion"].ToString();
                    lEIndDotacion.Add(obEIndDotacion);
                }
                drd.Close();
            }

            return (lEIndDotacion);
        }
    }
}