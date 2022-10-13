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
    public class CListarBoletin
    {
        public List<EListarBoletin> Listar_ListarBoletin(SqlConnection con)
        {
            List<EListarBoletin> lEListarBoletin = null;
            SqlCommand cmd = new SqlCommand("ASP_BOLETIN", con);
            cmd.CommandType = CommandType.StoredProcedure;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEListarBoletin = new List<EListarBoletin>();

                EListarBoletin obEListarBoletin = null;
                while (drd.Read())
                {
                    obEListarBoletin = new EListarBoletin();
                    obEListarBoletin.i_id = drd["i_id"].ToString();
                    obEListarBoletin.v_nombre = drd["v_nombre"].ToString();
                    obEListarBoletin.v_ruta = drd["v_ruta"].ToString();
                    lEListarBoletin.Add(obEListarBoletin);
                }
                drd.Close();
            }

            return (lEListarBoletin);
        }
    }
}