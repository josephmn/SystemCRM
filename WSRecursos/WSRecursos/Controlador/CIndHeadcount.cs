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
    public class CIndHeadcount
    {
        public List<EIndHeadcount> Listar_IndHeadcount(SqlConnection con)
        {
            List<EIndHeadcount> lEIndHeadcount = null;
            SqlCommand cmd = new SqlCommand("ASP_INDHEADCOUNT", con);
            cmd.CommandType = CommandType.StoredProcedure;
            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEIndHeadcount = new List<EIndHeadcount>();

                EIndHeadcount obEIndHeadcount = null;
                while (drd.Read())
                {
                    obEIndHeadcount = new EIndHeadcount();
                    obEIndHeadcount.i_anhio = drd["i_anhio"].ToString();
                    obEIndHeadcount.v_meses = drd["v_meses"].ToString();
                    obEIndHeadcount.i_cantidad = drd["i_cantidad"].ToString();
                    obEIndHeadcount.i_target = drd["i_target"].ToString();
                    obEIndHeadcount.i_desviacion = drd["i_desviacion"].ToString();
                    lEIndHeadcount.Add(obEIndHeadcount);
                }
                drd.Close();
            }

            return (lEIndHeadcount);
        }
    }
}