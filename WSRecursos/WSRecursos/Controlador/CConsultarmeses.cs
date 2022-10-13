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
    public class CConsultarmeses
    {
        public List<EConsultarmeses> Listar_Consultarmeses(SqlConnection con, Int32 id)
        {
            List<EConsultarmeses> lEConsultarmeses = null;
            SqlCommand cmd = new SqlCommand("ASP_CONSULTA_MESES", con);
            cmd.CommandType = CommandType.StoredProcedure;

            cmd.Parameters.AddWithValue("@id", SqlDbType.Int).Value = id;

            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lEConsultarmeses = new List<EConsultarmeses>();

                EConsultarmeses obEConsultarmeses = null;
                while (drd.Read())
                {
                    obEConsultarmeses = new EConsultarmeses();
                    obEConsultarmeses.id = drd["id"].ToString();
                    obEConsultarmeses.i_id = drd["i_id"].ToString();
                    obEConsultarmeses.v_nombre = drd["v_nombre"].ToString();
                    obEConsultarmeses.i_anhio = drd["i_anhio"].ToString();
                    obEConsultarmeses.i_estado = drd["i_estado"].ToString();
                    lEConsultarmeses.Add(obEConsultarmeses);
                }
                drd.Close();
            }

            return (lEConsultarmeses);
        }
    }
}