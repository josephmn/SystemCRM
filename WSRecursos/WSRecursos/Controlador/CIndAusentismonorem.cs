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
    public class CIndAusentismonorem
    {
        public List<EIndAusentismonorem> Listar_IndAusentismonorem(SqlConnection con)
        {
            List<EIndAusentismonorem> lEIndAusentismonorem = null;
            SqlCommand cmd = new SqlCommand("ASP_INDAUSENTISMONOREM", con);
            cmd.CommandType = CommandType.StoredProcedure;
            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEIndAusentismonorem = new List<EIndAusentismonorem>();

                EIndAusentismonorem obEIndAusentismonorem = null;
                while (drd.Read())
                {
                    obEIndAusentismonorem = new EIndAusentismonorem();
                    obEIndAusentismonorem.i_estado = drd["i_estado"].ToString();
                    obEIndAusentismonorem.v_periodo = drd["v_periodo"].ToString();
                    obEIndAusentismonorem.i_dias = drd["i_dias"].ToString();
                    obEIndAusentismonorem.i_total = drd["i_total"].ToString();
                    obEIndAusentismonorem.i_porc = drd["i_porc"].ToString();
                    lEIndAusentismonorem.Add(obEIndAusentismonorem);
                }
                drd.Close();
            }

            return (lEIndAusentismonorem);
        }
    }
}