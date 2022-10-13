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
    public class CIndAusentismorem
    {
        public List<EIndAusentismorem> Listar_IndAusentismorem(SqlConnection con)
        {
            List<EIndAusentismorem> lEIndAusentismorem = null;
            SqlCommand cmd = new SqlCommand("ASP_INDAUSENTISMOREM", con);
            cmd.CommandType = CommandType.StoredProcedure;
            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEIndAusentismorem = new List<EIndAusentismorem>();

                EIndAusentismorem obEIndAusentismorem = null;
                while (drd.Read())
                {
                    obEIndAusentismorem = new EIndAusentismorem();
                    obEIndAusentismorem.i_estado = drd["i_estado"].ToString();
                    obEIndAusentismorem.v_periodo = drd["v_periodo"].ToString();
                    obEIndAusentismorem.i_dias = drd["i_dias"].ToString();
                    obEIndAusentismorem.i_total = drd["i_total"].ToString();
                    obEIndAusentismorem.i_porc = drd["i_porc"].ToString();
                    lEIndAusentismorem.Add(obEIndAusentismorem);
                }
                drd.Close();
            }

            return (lEIndAusentismorem);
        }
    }
}