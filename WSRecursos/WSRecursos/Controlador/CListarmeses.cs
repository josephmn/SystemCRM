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
    public class CListarmeses
    {
        public List<EListarmeses> Listar_Listarmeses(SqlConnection con, Int32 post)
        {
            List<EListarmeses> lEListarmeses = null;
            SqlCommand cmd = new SqlCommand("ASP_LISTAR_MESES", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@post", SqlDbType.Int).Value = post;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEListarmeses = new List<EListarmeses>();

                EListarmeses obEListarmeses = null;
                while (drd.Read())
                {
                    obEListarmeses = new EListarmeses();
                    obEListarmeses.id = drd["id"].ToString();
                    obEListarmeses.i_id = drd["i_id"].ToString();
                    obEListarmeses.v_nombre = drd["v_nombre"].ToString();
                    obEListarmeses.i_anhio = drd["i_anhio"].ToString();
                    obEListarmeses.i_estado = drd["i_estado"].ToString();
                    obEListarmeses.v_color = drd["v_color"].ToString();
                    obEListarmeses.v_selected = drd["v_selected"].ToString();
                    lEListarmeses.Add(obEListarmeses);
                }
                drd.Close();
            }

            return (lEListarmeses);
        }
    }
}